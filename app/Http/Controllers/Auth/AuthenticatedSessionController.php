<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar formulario de inicio de sesión.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Procesar inicio de sesión.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $usuario = $request->user();

        /*
         * El usuario debe tener un rol activo.
         */
        if (
            ! $usuario->rol
            || ! $usuario->rol->estado
        ) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'dni' => 'Tu rol de acceso no se encuentra habilitado.',
            ]);
        }

        $request->session()->regenerate();

        /*
         * El administrador puede ingresar directamente
         * al dashboard.
         */
        if ($usuario->esAdministrador()) {
            return redirect()->route('dashboard');
        }

        /*
         * Redirigir al primer módulo disponible
         * según los permisos asignados.
         */
        $rutaDestino = match (true) {
            $usuario->tienePermiso('dashboard.ver') =>
                route('dashboard'),

            $usuario->tienePermiso('consultas.ver') =>
                route('admin.consultas.index'),

            $usuario->tienePermiso('solicitudes.ver') =>
                route('admin.tramites.index'),

            $usuario->tienePermiso('documentos.gestionar') =>
                route('admin.documentos.index'),

            $usuario->tienePermiso('publicaciones.gestionar') =>
                route('admin.publicaciones.index'),

            $usuario->tienePermiso('convocatorias.gestionar') =>
                route('admin.convocatorias.index'),

            $usuario->tienePermiso('postulaciones.revisar') =>
                route('admin.postulaciones.index'),

            $usuario->tienePermiso('galerias.gestionar') =>
                route('admin.galerias.index'),

            $usuario->tienePermiso('promociones.gestionar') =>
                route('admin.promociones.index'),

            $usuario->tienePermiso('usuarios.ver') =>
                route('admin.usuarios.index'),

            $usuario->tienePermiso('seguridad.administrar') =>
                route('admin.roles.index'),

            $usuario->tienePermiso('auditoria.ver') =>
                route('admin.auditorias.index'),

            default => null,
        };

        /*
         * Una cuenta sin permisos no debe permanecer
         * autenticada dentro del panel.
         */
        if (! $rutaDestino) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'dni' => 'Tu cuenta no tiene permisos habilitados para acceder al sistema.',
            ]);
        }

        return redirect()->to($rutaDestino);
    }

    /**
     * Cerrar sesión.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('inicio');
    }
}