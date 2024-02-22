<?php

namespace App\Models;

use App\Services\GenerateSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'status',
        'image',
        'video',
        'category_id',
        'admin_id',
        'revision_id',
        'order',
        'publish_level',
    ];

    protected $casts = [
        'publish_level' => 'integer',
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

    public function revision(): void
    {
        /** @var \App\Models\Admin $admin */
        $admin = auth('admins')->user();
        self::create([
            'title' => $this->title,
            'content' => $this->content,
            'slug' => GenerateSlug::generate('revision_' . $this->slug, self::class),
            'status' => StatusEnum::$REVISION,
            'video' => $this->video,
            'image' => $this->image,
            'category_id' => $this->category_id,
            'admin_id' => $admin->id,
            'revision_id' => $this->id,
            'order' => $this->order,
            'publish_level' => $this->publish_level,
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
        return $this->image ? asset('storage/' . $this->image) : asset('images/post-thumbnail-default.png');
    }

    public function prev(): self|null
    {
        $category = $this->category;
        if ($category) {
            $samePosts = $category->posts()->publish()->where('id', '!=', $this->id);
            return $samePosts->count() !== 0 ?
                $samePosts->where('order', '<=', $this->order)
                ->orderBy('order')
                ->orderBy('id', 'desc')
                ->first()
                :
                null;
        } else {
            $samePosts = self::publish()->where('category_id', null)->where('id', '!=', $this->id);
            return $samePosts->count() !== 0 ?
                $samePosts->where('order', '<=', $this->order)
                ->orderBy('order')
                ->orderBy('id', 'desc')
                ->first()
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
        if ($this->publish_level === PublishLevelEnum::$ANYONE || auth('admins')->check()) {
            return true;
        }
        /** @var \App\Models\User|null $user */
        $user = auth('users')->user();
        if (!$user) {
            return false;
        }
        return $user->status >= $this->publish_level;
    }

    public function publishLevelReadable(): string
    {
        return PublishLevelEnum::readableForFront($this->publish_level);
    }
}
