<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InflowRouteLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'inflow_route_id',
        'ip'
    ];

    protected static function booted()
    {
        static::addGlobalScope('ipIgnore', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $ignoreIps = config('access_log.ignore_ips');
            if ($ignoreIps) {
                $builder->whereNotIn('ip', $ignoreIps);
            }
        });
    }

    public function inflowRoute()
    {
        return $this->belongsTo(InflowRoute::class);
    }
}
