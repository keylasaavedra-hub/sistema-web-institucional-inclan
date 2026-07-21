<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $usuario = auth()->user();

        $rol = DB::table('roles')
            ->where('id', $usuario->rol_id)
            ->value('nombre');

        $estadisticas = [
            'usuarios' => DB::table('users')->count(),
            'publicaciones' => DB::table('publicaciones')->count(),
            'consultas' => DB::table('consultas')->count(),
            'solicitudes' => DB::table('solicitudes')->count(),
            'convocatorias' => DB::table('convocatorias')->count(),
            'postulaciones' => DB::table('postulaciones')->count(),
        ];

        return view('dashboard', compact(
            'usuario',
            'rol',
            'estadisticas'
        ));
    }
}