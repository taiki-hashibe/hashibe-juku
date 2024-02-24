<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineWebhookEvent extends Model
{
    use HasFactory;

    public const TYPE_MESSAGE = 'message';
    public const TYPE_FOLLOW = 'follow';
    public const TYPE_UNFOLLOW = 'unfollow';
    public const TYPE_JOIN = 'join';
    public const TYPE_LEAVE = 'leave';
    public const TYPE_POSTBACK = 'postback';
    public const TYPE_BEACON = 'beacon';
    public const TYPE_ACCOUNT_LINK = 'accountLink';
    public const TYPE_MEMBER_JOINED = 'memberJoined';
    public const TYPE_MEMBER_LEFT = 'memberLeft';
    public const TYPE_THINGS = 'things';

    protected $fillable = [
        'type',
        'mode',
        'timestamp',
        'source',
        'webhook_event_id',
        'delivery_content_is_redelivery',
        'reply_token',
        'message',
        'postback',
        'text',
        'mention',
        'quoted_message_id',
        'content_provider',
        'image_set',
        'file_name',
        'file_size',
        'title',
        'address',
        'latitude',
        'longitude',
        'package_id',
        'sticker_id',
        'unsend',
        'joined',
        'left',
        'video_play_complete',
        'beacon',
        'link',
        'things',
    ];

    protected $casts = [
        'source' => 'json',
        'delivery_content_is_redelivery' => 'boolean',
        'message' => 'json',
        'postback' => 'json',
        'mention' => 'json',
        'content_provider' => 'json',
        'image_set' => 'json',
        'file_size' => 'integer',
        'latitude' => 'decimal:10',
        'longitude' => 'decimal:10',
        'unsend' => 'json',
        'joined' => 'json',
        'left' => 'json',
        'video_play_complete' => 'json',
        'beacon' => 'json',
        'link' => 'json',
        'things' => 'json',
    ];

    public static function createByEvent($data)
    {
        return self::create([
            'type' => $data['type'],
            'mode' => $data['mode'],
            'timestamp' => $data['timestamp'],
            'source' => array_key_exists('source', $data) ? $data['source'] : null,
            'webhook_event_id' => $data['webhookEventId'],
            'delivery_content_is_redelivery' => array_key_exists('deliveryContent', $data) && array_key_exists('isRedelivery', $data['deliveryContent']) ? $data['deliveryContent']['isRedelivery'] : null,
            'reply_token' => array_key_exists('replyToken', $data) ? $data['replyToken'] : null,
            'message' => array_key_exists('message', $data) ? $data['message'] : null,
            'postback' => array_key_exists('postback', $data) ? $data['postback'] : null,
            'text' => array_key_exists('text', $data) ? $data['text'] : null,
            'mention' => array_key_exists('mention', $data) ? $data['mention'] : null,
            'quoted_message_id' => array_key_exists('quotedMessageId', $data) ? $data['quotedMessageId'] : null,
            'content_provider' => array_key_exists('contentProvider', $data) ? $data['contentProvider'] : null,
            'image_set' => array_key_exists('imageSet', $data) ? $data['imageSet'] : null,
            'file_name' => array_key_exists('fileName', $data) ? $data['fileName'] : null,
            'file_size' => array_key_exists('fileSize', $data) ? $data['fileSize'] : null,
            'title' => array_key_exists('title', $data) ? $data['title'] : null,
            'address' => array_key_exists('address', $data) ? $data['address'] : null,
            'latitude' => array_key_exists('latitude', $data) ? $data['latitude'] : null,
            'longitude' => array_key_exists('longitude', $data) ? $data['longitude'] : null,
            'package_id' => array_key_exists('packageId', $data) ? $data['packageId'] : null,
            'sticker_id' => array_key_exists('stickerId', $data) ? $data['stickerId'] : null,
            'unsend' => array_key_exists('unsend', $data) ? $data['unsend'] : null,
            'joined' => array_key_exists('joined', $data) ? $data['joined'] : null,
            'left' => array_key_exists('left', $data) ? $data['left'] : null,
            'video_play_complete' => array_key_exists('videoPlayComplete', $data) ? $data['videoPlayComplete'] : null,
            'beacon' => array_key_exists('beacon', $data) ? $data['beacon'] : null,
            'link' => array_key_exists('link', $data) ? $data['link'] : null,
            'things' => array_key_exists('things', $data) ? $data['things'] : null,
        ]);
    }

    public function user(): User | null
    {
        if (!array_key_exists('userId', $this->source)) {
            return null;
        }
        $user = User::where('line_id', $this->source['userId'])->first();
        return $user;
    }

    public function isMessage(): bool
    {
        return $this->type === self::TYPE_MESSAGE;
    }

    public function isFollow(): bool
    {
        return $this->type === self::TYPE_FOLLOW;
    }

    public function isUnfollow(): bool
    {
        return $this->type === self::TYPE_UNFOLLOW;
    }

    public function isJoin(): bool
    {
        return $this->type === self::TYPE_JOIN;
    }

    public function isLeave(): bool
    {
        return $this->type === self::TYPE_LEAVE;
    }

    public function isPostback(): bool
    {
        return $this->type === self::TYPE_POSTBACK;
    }

    public function isBeacon(): bool
    {
        return $this->type === self::TYPE_BEACON;
    }

    public function isAccountLink(): bool
    {
        return $this->type === self::TYPE_ACCOUNT_LINK;
    }

    public function isMemberJoined(): bool
    {
        return $this->type === self::TYPE_MEMBER_JOINED;
    }

    public function isMemberLeft(): bool
    {
        return $this->type === self::TYPE_MEMBER_LEFT;
    }

    public function isThings(): bool
    {
        return $this->type === self::TYPE_THINGS;
    }
}
