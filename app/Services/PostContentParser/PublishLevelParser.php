<?php

namespace App\Services\PostContentParser;

use App\Models\PublishLevelEnum;
use Illuminate\Support\Str;

class PublishLevelParser implements Parser
{
    public static string $trialHtml = '<p><abbr title="publish-level:trial">-</abbr></p>';
    public static string $membershipHtml = '<p><abbr title="publish-level:membership">-</abbr></p>';

    public static function parse(string $content): string
    {
        if (!auth('admins')->check()) {
            /** @var \App\Models\User|null $user */
            $user = auth('users')->user();
            if (!$user) {
                $content = Str::before($content, self::$trialHtml);
            } else {
                $publishLevel = $user->status;
                if ($publishLevel <= PublishLevelEnum::$TRIAL) {
                    $content = Str::before($content, self::$membershipHtml);
                }
            }
        };

        return Str::replace(self::$trialHtml, '', Str::replace(self::$membershipHtml, '', $content));
    }
}
