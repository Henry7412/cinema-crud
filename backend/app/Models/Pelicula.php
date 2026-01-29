<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'fecha_publicacion',
        'imagen',
        'estado',
    ];

    protected $appends = ['imagen_url'];

    public function turnos()
    {
        return $this->belongsToMany(Turno::class);
    }

    public function getImagenUrlAttribute()
    {
        return $this->imagen
            ? asset('storage/' . $this->imagen)
            : null;
    }
}
