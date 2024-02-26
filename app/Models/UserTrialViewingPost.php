<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTrialViewingPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, self>
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Post, self>
     */
    public function post(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
