<?php

namespace App\Models;

class StatusEnum
{
    public static string $PUBLISH = 'publish';
    public static string $DRAFT = 'draft';
    public static string $TRASH = 'trash';
    public static string $REVISION = 'revision';

    /**
     * @return array<array<string, string>>
     */
    public static function toArray(): array
    {
        return [
            [
                'value' => self::$PUBLISH,
                'label' => '公開'
            ],
            [
                'value' => self::$DRAFT,
                'label' => '下書き'
            ],
            [
                'value' => self::$TRASH,
                'label' => 'ゴミ箱'
            ],
            [
                'value' => self::$REVISION,
                'label' => 'リビジョン'
            ]
        ];
    }

    /**
     * @return array<array<string, string>>
     */
    public static function toArrayForEditor(): array
    {
        return [
            [
                'value' => self::$PUBLISH,
                'label' => '公開'
            ],
            [
                'value' => self::$DRAFT,
                'label' => '下書き'
            ]
        ];
    }

    public static function readable(string $status): string
    {
        $array = self::toArray();
        foreach ($array as $item) {
            if ($item['value'] === $status) {
                return $item['label'];
            }
        }
        return '';
    }
}
