<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public static function isUserRole($i)
    {
        return Auth::user() && Auth::user()->role === $i;
    }
}
