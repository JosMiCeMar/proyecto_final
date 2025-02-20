<?php

namespace App\Http\Middleware;

use App\Models\Responsable;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware para verificar si el usuario es un responsable.
 */
class CheckResp
{
    /**
     * Maneja una solicitud de entrada.
     *
     * @param  Request $request
     * @param  Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(!Responsable::isRespons()){
            return redirect(route('sin_acceso'));
        }

        return $next($request);
    }
}
