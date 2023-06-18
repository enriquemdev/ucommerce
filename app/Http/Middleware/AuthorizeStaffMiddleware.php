<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeStaffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Validacion del tipo de usuario a la hora de acceder a una vista del panel de administracion de Filament
        $is_staff = auth()->user()->is_staff;
        abort_if($is_staff != 1, 403);
        //enrique

        return $next($request);
    }
}
