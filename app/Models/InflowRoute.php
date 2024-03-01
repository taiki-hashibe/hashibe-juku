<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InflowRoute extends Model
{
    use HasFactory;

    protected $fillable = [
        'route',
        'source',
        'key',
        'redirect_url',
    ];

    public function logs()
    {
        return $this->hasMany(InflowRouteLog::class);
    }

    public function url(): string
    {
        return route('inflow-route', [
            'key' => $this->key
        ]);
    }
}
