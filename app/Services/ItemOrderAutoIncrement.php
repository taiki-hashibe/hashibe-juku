<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;

class ItemOrderAutoIncrement
{
    public static function category(int $parentId = null): int
    {
        $item = Category::where('parent_id', $parentId)->orderBy('order', 'desc')->first();
        if ($item) {
            return $item->order + 1;
        }
        return 1;
    }

    public static function post(int $categoryId = null): int
    {
        $item = Post::where('category_id', $categoryId)->orderBy('order', 'desc')->first();
        if ($item) {
            return $item->order + 1;
        }
        return 1;
    }
}
