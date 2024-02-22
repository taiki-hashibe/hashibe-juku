<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'url',
        'route_name'
    ];

    protected static function booted()
    {
        /** @var \App\Models\User $user */
        $user = auth('users')->user();
        /** @var \Illuminate\Routing\Route $route */
        $route = request()->route();

        $categorySlug = request()->category;
        $category = null;
        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();
        }
        $postSlug = request()->post;
        $post = null;
        if ($postSlug) {
            $post = Post::where('slug', $postSlug)->first();
        }
        $routeName = $route->getName();
        if ($routeName) {
            $routeName = Str::replace(['.'], '-', $routeName);
            if (!config("routes.$routeName")) {
                $routeName = null;
            }
        }
        static::creating(function (AccessLog $accessLog) use ($user, $routeName, $category, $post) {
            $accessLog->user_id = $user->id;
            $accessLog->url = request()->url();
            $accessLog->route_name = $routeName;
            $accessLog->category_id = $category ? $category->id : null;
            $accessLog->post_id = $post ? $post->id : null;
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, self>
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Category, self>
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Post, self>
     */
    public function post(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Post::class)->withDefault();
    }
}
