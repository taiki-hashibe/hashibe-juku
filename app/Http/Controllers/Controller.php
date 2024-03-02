<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        /** @var \App\Models\User $user */
        $user = auth('users')->user();
        AccessLog::register($user);
    }
}
