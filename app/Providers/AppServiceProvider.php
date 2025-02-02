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
        // Limitación de solicitudes públicas por minuto
        RateLimiter::for('web', function ($request) {
            // Límite de 60 solicitudes por minuto por IP
            return Limit::perMinute(50)->by($request->ip());
        });

        // Limitación de solicitudes de usuarios registrados por minuto
        RateLimiter::for('user-actions', function ($request) {
            return $request->user()
                ? Limit::perMinute(70)->by($request->user()->id)
                : Limit::perMinute(70)->by($request->ip());
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
