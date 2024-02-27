<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculum_id',
        'post_id',
        'order',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
