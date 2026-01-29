<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignTurnosRequest;
use App\Models\Pelicula;

class PeliculaTurnoController extends Controller
{
    public function assign(AssignTurnosRequest $request, Pelicula $pelicula)
    {
        $pelicula->turnos()->sync($request->turno_ids);

        return response()->json([
            'message' => 'Turnos asignados correctamente',
            'pelicula' => $pelicula->load('turnos')
        ]);
    }
}
