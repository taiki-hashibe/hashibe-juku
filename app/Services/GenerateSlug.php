<?php

namespace App\Services;

use Illuminate\Support\Str;

class GenerateSlug
{
    public static function generate(string|null $value = null, string $modelClass): string
    {
        $model = new $modelClass;
        if (!$model instanceof \Illuminate\Database\Eloquent\Model) {
            throw new \Exception('Model class is invalid');
        }
        if (!$value) {
            $value = Str::random(5);
        }
        $slug = self::escape($value);
        $item = $model->where('slug', $slug)->first();
        if ($item) {
            $slug = $slug . '-' . Str::random(5);
            return self::generate($slug, $modelClass);
        }
        return $slug;
    }

    private static function escape(string $str): string
    {
        $str = mb_ereg_replace('[^[:alnum:]ぁ-ゞ一-龠]+', '-', $str);
        if (!$str) {
            throw new \Exception('Slug is empty');
        }
        $str = preg_replace('/\-+/', '-', $str);
        if (!$str) {
            throw new \Exception('Slug is empty');
        }

        $str = ltrim($str, '-');

        $str = rtrim($str, '-');

        $str = preg_replace('/^[\-]+/', '', $str);
        if (!$str) {
            throw new \Exception('Slug is empty');
        }
        $str = preg_replace('/[\-]+$/', '', $str);
        if (!$str) {
            throw new \Exception('Slug is empty');
        }
        return $str;
    }
}
