<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'type',
        'order'
    ];

    /**
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeSortOrder($query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->orderBy('order');
    }
}
