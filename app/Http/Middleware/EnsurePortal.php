<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsurePortal
{
    public function handle(Request $request, Closure $next, string $portal)
    {
        $user = $request->user();

        // Si no está logueado, al login
        if (! $user) {
            return redirect()->route('login');
        }

        // Si no tiene portal elegido, que elija (solo si entró por login genérico)
        if (! $user->portal) {
            return redirect()->route('portal.selector');
        }

        // Si está en el portal equivocado, lo mandamos al selector para cambiarlo
        if ($user->portal !== $portal) {
            return redirect()->route('portal.selector');
        }

        return $next($request);
    }
}
