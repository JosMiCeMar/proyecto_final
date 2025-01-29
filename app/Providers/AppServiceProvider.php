<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Inertia\Inertia;

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
        // Configurar limitación de solicitudes
        RateLimiter::for('web', function ($request) {
            // Límite de 60 solicitudes por minuto por IP
            return Limit::perMinute(10)->by($request->ip());
        });

        RateLimiter::for('user-actions', function ($request) {
            // Límite diferente para usuarios autenticados
            return $request->user()
                ? Limit::perMinute(50)->by($request->user()->id)
                : Limit::perMinute(50)->by($request->ip());
        });

        //Funcion para retornar mensajes informativos en la sesion
        Inertia::share([
            'flash' => function () {
                return [
                    'msg' => session('msg'),
                ];
            },
        ]);
    }
}
