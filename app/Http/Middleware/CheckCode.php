<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware para verificar si el usuario ha ingresado un código.
 */
class CheckCode
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
        if (!$request->session()->has('cod')) {
            return redirect(route('cod_registro.check')); 
        }

        return $next($request);
    }
}
