<?php

namespace App\Models;

class PublishLevelEnum
{
    public static int $ANYONE = 0;
    public static int $TRIAL = 50;
    public static int $MEMBERSHIP = 100;

    /**
     * @return array<array<string, string|int>>
     */
    public static function toArray(): array
    {
        return [
            [
                'value' => self::$ANYONE,
                'label' => '誰でも'
            ],
            [
                'value' => self::$TRIAL,
                'label' => 'トライアル'
            ],
            [
                'value' => self::$MEMBERSHIP,
                'label' => '有料会員'
            ]
        ];
    }

    /**
     * @return array<array<string, string|int>>
     */
    public static function toArrayForUser(): array
    {
        return [
            [
                'value' => self::$MEMBERSHIP,
                'label' => '有料会員'
            ],
            [
                'value' => self::$TRIAL,
                'label' => 'トライアル'
            ]
        ];
    }

    /**
     * @return array<array<string, string|int>>
     */
    public static function toArrayForFront(): array
    {
        return [
            [
                'value' => self::$TRIAL,
                'label' => '無料会員'
            ],
            [
                'value' => self::$MEMBERSHIP,
                'label' => '有料会員'
            ]
        ];
    }

    public static function readable(int $level): string
    {
        $array = self::toArray();
        foreach ($array as $item) {
            if ($item['value'] === $level) {
                return (string) $item['label'];
            }
        }
        return '';
    }

    public static function readableForFront(int $level): string
    {
        $array = self::toArrayForFront();
        foreach ($array as $item) {
            if ($item['value'] === $level) {
                return (string) $item['label'];
            }
        }
        return '';
    }
}
