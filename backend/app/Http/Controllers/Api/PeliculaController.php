<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePeliculaRequest;
use App\Http\Requests\UpdatePeliculaRequest;
use App\Models\Pelicula;
use Illuminate\Support\Facades\Storage;

class PeliculaController extends Controller
{
    public function index()
    {
        return Pelicula::with('turnos')->get();
    }

    public function store(StorePeliculaRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('peliculas', 'public');
            $data['imagen'] = $path;
        }

        $pelicula = Pelicula::create($data);

        return response()->json($pelicula, 201);
    }


    public function show(Pelicula $pelicula)
    {
        return $pelicula->load('turnos');
    }

    public function update(UpdatePeliculaRequest $request, Pelicula $pelicula)
    {
        $data = $request->validated();

        if ($request->hasFile('imagen')) {
            if ($pelicula->imagen && Storage::disk('public')->exists($pelicula->imagen)) {
                Storage::disk('public')->delete($pelicula->imagen);
            }

            $path = $request->file('imagen')->store('peliculas', 'public');
            $data['imagen'] = $path;
        }

        $pelicula->update($data);

        return response()->json($pelicula->fresh());
    }



    public function destroy(Pelicula $pelicula)
    {
        if ($pelicula->imagen && Storage::disk('public')->exists($pelicula->imagen)) {
            Storage::disk('public')->delete($pelicula->imagen);
        }

        $pelicula->delete();

        return response()->json(['message' => 'Película eliminada']);
    }
}
