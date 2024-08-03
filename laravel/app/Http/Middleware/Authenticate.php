<?php

namespace App\Http\Middleware;

use App\Http\Services\DomainService;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return DomainService::getFullHost(config('app.sudomains.auth'));
    }
}
