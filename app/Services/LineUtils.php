<?php

namespace App\Services;

use App\Models\User;

class LineUtils
{
    public static function getProfile(string $lineId)
    {
        $client = new \GuzzleHttp\Client();
        $config = new \LINE\Clients\MessagingApi\Configuration();
        $config->setAccessToken(config('line.messaging_api.channel_access_token'));
        $messagingApi = new \LINE\Clients\MessagingApi\Api\MessagingApiApi(
            client: $client,
            config: $config,
        );
        return $messagingApi->getProfile($lineId);
    }

    public static function getProfileByIdToken(string $idToken)
    {
        $url = 'https://api.line.me/oauth2/v2.1/verify';
        $params = [
            'id_token' => $idToken,
            'client_id' => config('line.login.channel_id')
        ];
        $query_params = http_build_query($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query_params);
        $return_value = curl_exec($ch);
        return json_decode($return_value, true);
    }

    public static function getUserOrCreate(\LINE\Clients\MessagingApi\Model\UserProfileResponse $profile)
    {
        $user = User::where('line_id', $profile->getUserId())->first();
        if (!$user) {
            $user = User::create([
                'name' => $profile->getDisplayName(),
                'line_id' => $profile->getUserId(),
                'status_message' => $profile->getStatusMessage(),
                'picture_url' => $profile->getPictureUrl(),
            ]);
        } else {
            $user->update([
                'name' => $profile->getDisplayName(),
                'status_message' => $profile->getStatusMessage(),
                'picture_url' => $profile->getPictureUrl(),
            ]);
        }
        return $user;
    }
}
