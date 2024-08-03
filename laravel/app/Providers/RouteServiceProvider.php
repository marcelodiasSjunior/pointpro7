<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            $domain = config('app.domain');

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->domain(config('app.sudomains.auth') . '.' . $domain)
                ->group(base_path('routes/auth.php'));

            Route::middleware(['web', 'auth:sanctum', 'isRole:1'])
                ->domain(config('app.sudomains.manager') . '.' . $domain)
                ->group(base_path('routes/manager.php'));

            Route::middleware(['web', 'auth:sanctum', 'isRole:2'])
                ->domain(config('app.sudomains.painel') . '.' . $domain)
                ->group(base_path('routes/painel.php'));

            Route::middleware(['web', 'auth:sanctum', 'isRole:3'])
                ->domain(config('app.sudomains.funcionario') . '.' . $domain)
                ->group(base_path('routes/funcionario.php'));
        });
    }
}
