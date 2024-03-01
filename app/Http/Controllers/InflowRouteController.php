<?php

namespace App\Http\Controllers;

use App\Models\InflowRoute;
use App\Models\InflowRouteLog;

class InflowRouteController extends Controller
{
    public function index(string $key)
    {
        $inflowRoute = InflowRoute::where('key', $key)->first();
        if (!$inflowRoute) {
            return redirect()->route('home');
        }
        if (!request()->test) {
            InflowRouteLog::create([
                'inflow_route_id' => $inflowRoute->id,
            ]);
        }
        return redirect($inflowRoute->redirect_url);
    }
}
