<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrialLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_1',
        'date_2',
        'date_3',
        'request'
    ];

    protected $casts = [
        'datetime' => 'date_1',
        'datetime' => 'date_2',
        'datetime' => 'date_3'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, self>
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
