<?php

namespace App\Http\Middleware;

use App\Http\Services\DomainService;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class IsRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, Int $role): Response
    {
        if (Auth::user() && $role === Auth::user()->role) {
            if (Auth::user()->role === 2 && (!Auth::user()->company || !Auth::user()->company->razao_social) && Route::current()->uri() !== 'onboarding') {
                return redirect('/onboarding');
            }

            if (Auth::user()->role === 3 && $request->user()->biometria_facial->count() && Route::current()->uri() === 'onboarding') {
                return redirect('/');
            }

            if (Auth::user()->role === 3 && !$request->user()->biometria_facial->count() && Route::current()->uri() !== 'onboarding' && $request->user()->funcionario->company->plan === 2) {
                return redirect('/onboarding');
            }
            return $next($request);
        }
        return Redirect::to(DomainService::getFullHost(config('app.sudomains.auth')));
    }
}
