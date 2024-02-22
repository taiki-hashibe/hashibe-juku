<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    public static $routeNames = [
        'line.step.step-1',
        'line.step.step-2'
    ];

    protected $fillable = [
        'url',
        'route_name',
        'user_id',
        'value'
    ];

    protected $casts = [
        'value' => 'json'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, self>
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
