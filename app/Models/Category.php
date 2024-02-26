<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'image',
        'order',
        'admin_id'
    ];

    /**
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeOnlyHasPost($query): \Illuminate\Database\Eloquent\Builder
    {
        $maxDepth = self::getMaxChildrenDepth();
        $selector = 'children';
        $query
            ->whereHas('posts', fn ($p) => $p
                ->publish())
            ->orWhereHas('children', fn ($c) => $c->whereHas('posts', fn ($p) => $p
                ->publish()));
        for ($i = 0; $i <= $maxDepth - 2; $i++) {
            $selector .= '.children';
            $query->orWhereHas($selector, fn ($c) => $c->whereHas('posts', fn ($p) => $p
                ->publish()));
        }
        return $query;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeSortOrder($query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->orderBy('order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public static function parentCategories(): \Illuminate\Database\Eloquent\Builder
    {
        return self::where('parent_id', null)->orderBy('order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<self, self>
     */
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<self>
     */
    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Post>
     */
    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<AccessLog>
     */
    public function accessLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AccessLog::class);
    }

    public function thumbnail(): string|null
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/post-thumbnail-default.png');
    }

    /**
     * @return Builder<Post>
     */
    public function postAll(): Builder
    {
        $collection = new Collection();
        foreach ($this->posts as $post) {
            $collection->push($post);
        }
        if ($this->children->count() !== 0) {
            $this->getChildrenPosts($this, $collection);
        }
        return Post::whereIn('id', $collection->pluck('id'));
    }

    /**
     * @param self $currentItem
     * @param Collection<(int|string), Model> $collection
     * @return Collection<(int|string), Model>
     */
    private function getChildrenPosts(self $currentItem, Collection $collection): Collection
    {
        $children = $currentItem->children;
        foreach ($children as $child) {
            foreach ($child->posts as $post) {
                $collection->push($post);
            }
            if (!$child->children->count() !== 0) {
                $this->getChildrenPosts($child, $collection);
            }
        }
        return $collection;
    }

    /**
     * @return Builder<CompletePost>
     */
    public function complete(): Builder
    {
        return CompletePost::where('user_id', auth('users')->id())->where('id', $this->id);
    }

    /**
     * @return Builder<Post>
     */
    public function completeAll(): Builder
    {
        $collection = new Collection();
        /** @var \App\Models\User $user */
        $user = auth('users')->user();
        $postAll = $this->postAll();
        foreach ($postAll->get() as $post) {
            /** @var \App\Models\Post $post */
            if (CompletePost::where('user_id', $user->id)->where('post_id', $post->id)->exists()) {
                $collection->push($post);
            }
        }
        return Post::whereIn('id', $collection->pluck('id'));
    }

    public function isComplete(): bool
    {
        return false;
    }

    public function prev(): self|null
    {

        $sameCategories = $this->parent?->children()->onlyHasPost()->where('id', '!=', $this->id);
        return $sameCategories && $sameCategories->count() !== 0 ?
            $sameCategories->where('order', '<=', $this->order)
            ->orderBy('order')
            ->orderBy('id', 'desc')
            ->first()
            :
            null;
    }

    public function next(): self|null
    {
        $sameCategories = $this->parent?->children()->onlyHasPost()->where('id', '!=', $this->id);
        if ($sameCategories) {
            return $sameCategories->count() !== 0 ? $sameCategories
                ->where('order', '>', $this->order)
                ->orderBy('order')
                ->orderBy('id')
                ->first() : null;
        } else {
            $sameCategories = self::parentCategories()->onlyHasPost()->where('id', '!=', $this->id);
            return $sameCategories->count() !== 0 ? $sameCategories
                ->where('order', '>', $this->order)
                ->orderBy('order')
                ->orderBy('id')
                ->first() : null;
        }
    }

    public function getChildrenDepth(int $depth = 0): int
    {
        $children = $this->children;
        if ($children->count() === 0) {
            return $depth;
        }
        $depth++;
        $depths = [];
        foreach ($children as $child) {
            $depths[] = $child->getChildrenDepth($depth);
        }
        if ($depths === []) {
            return 0;
        }
        return max($depths);
    }

    public static function getMaxChildrenDepth(): int
    {
        // カテゴリー全体の最大の深さを取得する
        $categories = self::parentCategories()->get();
        $depths = [];
        foreach ($categories as $category) {
            $depths[] = $category->getChildrenDepth();
        }
        if ($depths === []) {
            return 0;
        }
        return max($depths);
    }
}
