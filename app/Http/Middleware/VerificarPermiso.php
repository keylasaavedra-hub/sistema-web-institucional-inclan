<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarPermiso
{
    public function handle(
        Request $request,
        Closure $next,
        string $permiso
    ): Response {
        $usuario = $request->user();

        if (! $usuario) {
            return redirect()
                ->route('login');
        }

        if (! $usuario->estado) {
            auth()->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'dni' => 'Tu cuenta se encuentra desactivada.',
                ]);
        }

        if (! $usuario->rol || ! $usuario->rol->estado) {
            auth()->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'dni' => 'Tu rol se encuentra inactivo o no está asignado.',
                ]);
        }

        if ($usuario->esAdministrador()) {
            return $next($request);
        }

        if (! $usuario->tienePermiso($permiso)) {
            abort(
                403,
                'No tienes permiso para acceder a esta sección.'
            );
        }

        return $next($request);
    }
}