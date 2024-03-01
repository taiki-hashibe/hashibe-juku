<?php

namespace App\Services;

use Illuminate\Support\Str;

class GenerateUniqueText
{
    public static function generate(string $modelClass, string $column, string $id = null): string
    {
        $model = new $modelClass;
        if (!$model instanceof \Illuminate\Database\Eloquent\Model) {
            throw new \Exception('Model class is invalid');
        }
        if (!$id) {
            $id = Str::random(5);
        }
        $item = $model->where($column, $id)->first();
        if ($item) {
            $id = $id . '-' . Str::random(5);
            return self::generate($modelClass, $column, $id);
        }
        return $id;
    }
}
