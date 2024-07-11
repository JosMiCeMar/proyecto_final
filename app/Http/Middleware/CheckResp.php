<?php

namespace App\Http\Middleware;

use App\Models\Responsable;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckResp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(!Responsable::isRespons()){
            return redirect(route('sin_acceso'));
        }

        return $next($request);
    }
}
