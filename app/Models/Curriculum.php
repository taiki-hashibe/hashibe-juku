<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Curriculum extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'order',
        'slug'
    ];

    /**
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeOnlyHasPost($query): \Illuminate\Database\Eloquent\Builder
    {
        $query->whereHas('posts');
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

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'curriculum_posts')
            ->withPivot('order')
            ->orderBy('curriculum_posts.order')
            ->publish();
    }
}
