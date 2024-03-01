<?php

namespace App\Models;

use App\Services\GenerateSlug;
use App\Services\PostContentParser\PublishLevelParser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'content_free',
        'slug',
        'status',
        'image',
        'video',
        'video_free',
        'category_id',
        'admin_id',
        'revision_id',
        'order',
        'publish_level',
        'description',
        'line_link',
        'public_release_at'
    ];

    protected $casts = [
        'publish_level' => 'integer',
        'public_release_at' => 'datetime'
    ];

    /**
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopePublish(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', StatusEnum::$PUBLISH);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeDraft(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', StatusEnum::$DRAFT);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeEditable(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', StatusEnum::$DRAFT)->orWhere('status', StatusEnum::$PUBLISH);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeSortOrder(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->orderBy('order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Post>
     */
    public function getRevision(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class, 'revision_id')->orderByDesc('created_at');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Post, self>
     */
    public function original(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Post::class, 'revision_id');
    }

    public function isEditable(): bool
    {
        return $this->status === StatusEnum::$DRAFT || $this->status === StatusEnum::$PUBLISH;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<AccessLog>
     */
    public function accessLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AccessLog::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Bookmark>
     */
    public function bookmarks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<CompletePost>
     */
    public function completes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CompletePost::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function getInTheSameCategory()
    {
        $category = $this->category;
        if ($category) {
            return $category->posts()->publish()->sortOrder();
        }
        return self::publish()->where('category_id', null)->sortOrder();
    }

    public function revision(): void
    {
        /** @var \App\Models\Admin $admin */
        $admin = auth('admins')->user();
        self::create([
            'title' => $this->title,
            'content' => $this->content,
            'content_free' => $this->content_free,
            'slug' => GenerateSlug::generate('revision_' . $this->slug, self::class),
            'status' => StatusEnum::$REVISION,
            'video' => $this->video,
            'video_free' => $this->video_free,
            'image' => $this->image,
            'category_id' => $this->category_id,
            'admin_id' => $admin->id,
            'revision_id' => $this->id,
            'order' => $this->order,
            'publish_level' => $this->publish_level,
            'line_link' => $this->line_link
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Category, self>
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Admin, self>
     */
    public function admin(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function thumbnail(): string|null
    {
        return $this->image ?? asset('images/post-thumbnail-default.png');
    }

    public function getDescription(): string|null
    {
        if ($this->description) {
            return $this->description;
        }
        if (!$this->content_free && !$this->content) {
            return null;
        }
        /** @var User $user */
        $user = auth('users')->user();
        $trialView = $user ? UserTrialViewingPost::where('user_id', $user->id)->where('post_id', $this->id)->exists() : false;
        $subscribed = $user ? $user->subscribed('online-salon') : false;
        $content = ($user && $subscribed) || $trialView ? $this->content : ($this->content_free ?? $this->content);
        if (!$content) {
            return null;
        }
        $content = PublishLevelParser::parse($content);
        return html_entity_decode(strip_tags($content));
    }

    public function prev(): self|null
    {
        $category = $this->category;
        if ($category) {
            $samePosts = $category->posts()->publish()->where('id', '!=', $this->id)->where('order', '<=', $this->order)->orderBy('order', 'desc');
            return $samePosts->count() !== 0 ?
                $samePosts->where('order', '<=', $this->order)
                ->first()
                :
                null;
        } else {
            $samePosts = self::publish()->where('category_id', null)->where('id', '!=', $this->id)->where('order', '<=', $this->order)->orderBy('order', 'desc');
            return $samePosts->count() !== 0 ?
                $samePosts->first()
                :
                null;
        }
    }

    public function next(): self|null
    {
        $category = $this->category;
        if ($category) {
            $samePosts = $category->posts()->publish()->where('id', '!=', $this->id);
            return $samePosts->count() !== 0 ? $samePosts
                ->where('order', '>', $this->order)
                ->orderBy('order')
                ->orderBy('id')
                ->first() : null;
        } else {
            $samePosts = self::publish()->where('category_id', null)->where('id', '!=', $this->id);
            return $samePosts->count() !== 0 ? $samePosts
                ->where('order', '>', $this->order)
                ->orderBy('order')
                ->orderBy('id')
                ->first() : null;
        }
    }

    public function isCanView(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = auth('users')->user();
        if (!$user) {
            return false;
        }
        return $user->subscribed('online-salon') || UserTrialViewingPost::where('user_id', $user->id)->where('post_id', $this->id)->exists();
    }

    public function publishLevelReadable(): string
    {
        return PublishLevelEnum::readableForFront($this->publish_level);
    }

    public function getRouteCategoryOrPost(bool $auth = null)
    {
        if ($auth === true || ($auth === null && auth('users')->check())) {
            if ($this->category) {
                return route('user.post.category', [
                    'category' => $this->category->slug,
                    'post' => $this->slug
                ]);
            } else {
                return route('user.post.post', [
                    'post' => $this->slug
                ]);
            }
        } else {
            if ($this->category) {
                return route('post.category', [
                    'category' => $this->category->slug,
                    'post' => $this->slug
                ]);
            } else {
                return route('post.post', [
                    'post' => $this->slug
                ]);
            }
        }
    }
}
