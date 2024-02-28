<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use App\Models\LineWebhookEvent;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function index()
    {
        foreach (request()->events as $e) {
            $le = LineWebhookEvent::createByEvent($e);
            $source = array_key_exists('source', $e) ? $e['source'] : null;
            if (!$source) {
                continue;
            }
            $lineId = array_key_exists('userId', $source) ? $source['userId'] : null;
            if (!$lineId) {
                continue;
            }
            $client = new \GuzzleHttp\Client();
            $config = new \LINE\Clients\MessagingApi\Configuration();
            $config->setAccessToken(config('line.messaging_api.channel_access_token'));
            $messagingApi = new \LINE\Clients\MessagingApi\Api\MessagingApiApi(
                client: $client,
                config: $config,
            );
            try {
                $profile = $messagingApi->getProfile($lineId);
                if (User::where('line_id', $lineId)->doesntExist()) {
                    $user = User::create([
                        'name' => $profile->getDisplayName(),
                        'line_id' => $lineId,
                        'status_message' => $profile->getStatusMessage(),
                        'picture_url' => $profile->getPictureUrl(),
                    ]);
                    if ($le->isFollow()) {
                        $user->update([
                            'line_status' => 'follow',
                        ]);
                    }
                    if ($le->isUnfollow()) {
                        $user->update([
                            'line_status' => 'unfollow',
                        ]);
                    }
                } else {
                    $user = User::where('line_id', $lineId)->first();
                    $user->update([
                        'name' => $profile->getDisplayName(),
                        'status_message' => $profile->getStatusMessage(),
                        'picture_url' => $profile->getPictureUrl(),
                    ]);
                    if ($le->isFollow()) {
                        $user->update([
                            'line_status' => 'follow',
                        ]);
                    }
                    if ($le->isUnfollow()) {
                        $user->update([
                            'line_status' => 'unfollow',
                        ]);
                    }
                }
            } catch (\LINE\Clients\MessagingApi\ApiException $e) {
                $headers = $e->getResponseHeaders();
                $lineRequestId = isset($headers['x-line-request-id']) ? $headers['x-line-request-id'][0] : 'Not Available';
                $httpStatusCode = $e->getCode();
                $errorMessage = $e->getResponseBody();

                Log::info("x-line-request-id: $lineRequestId");
                Log::info("http status code: $httpStatusCode");
                Log::info("error response: $errorMessage");
            }
        }
    }
}
