<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Checkrole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    /* Agregamos string $role */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        /* Para restringir rutas. */
        if (!Auth::check() || Auth::user()->role != $role) {
            abort(403, '¡¡No tienes permiso para acceder a esta pagina.!!');
        }


        /* Para restringir rutas. */

        return $next($request);
    }
}
