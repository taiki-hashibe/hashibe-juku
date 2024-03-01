<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InflowRouteLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'inflow_route_id',
    ];

    public function inflowRoute()
    {
        return $this->belongsTo(InflowRoute::class);
    }
}
