<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTurnoRequest;
use App\Models\Turno;

class TurnoController extends Controller
{
    public function index()
    {
        return Turno::all();
    }

    public function store(StoreTurnoRequest $request)
    {
        $turno = Turno::create($request->validated());
        return response()->json($turno, 201);
    }

    public function show(Turno $turno)
    {
        return $turno;
    }

    public function update(StoreTurnoRequest $request, Turno $turno)
    {
        $turno->update($request->validated());
        return response()->json($turno);
    }

    public function destroy(Turno $turno)
    {
        $turno->delete();
        return response()->json(['message' => 'Turno eliminado']);
    }
}
