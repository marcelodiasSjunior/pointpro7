<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \URL::forceScheme('https');
        \Carbon\Carbon::setLocale(config('app.locale'));

        // carrega as notificações
        view()->composer('templates.company', function ($view) {
            $notificacoes = \App\Models\Notificacao::where('company_id', auth()->user()->company->id)
                ->where('read', 0)
                ->orderBy('created_at', 'desc')
                ->get();

            $view->with('notificacoes', $notificacoes);
        });
    }
}
