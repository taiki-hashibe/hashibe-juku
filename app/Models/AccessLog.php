<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class AccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'url',
        'route_name',
        'category_id',
        'post_id',
        'tag_id',
        'curriculum_id',
        'ip'
    ];

    protected static function booted()
    {
        static::addGlobalScope('ipIgnore', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $ignoreIps = config('access_log.ignore_ips');
            if ($ignoreIps) {
                $builder->whereNotIn('ip', $ignoreIps);
            }
        });
    }

    public static function register(User $user = null)
    {
        $ip = request()->ip();
        $routeName = Route::currentRouteName();
        if (Str::startsWith($routeName, 'admin.')) return;
        self::create([
            'user_id' => $user?->id,
            'url' => request()->url(),
            'route_name' => $routeName,
            'category_id' => request()->category ? Category::where('slug', request()->category)->first()?->id : null,
            'post_id' => request()->post ? Post::where('slug', request()->post)->first()?->id : null,
            'tag_id' => request()->tag ? Tag::where('slug', request()->tag)->first()?->id : null,
            'curriculum_id' => request()->curriculum ? Curriculum::where('slug', request()->curriculum)->first()?->id : null,
            'ip' => $ip
        ]);
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
