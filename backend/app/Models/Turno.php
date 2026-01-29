<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $fillable = [
        'hora',
        'estado',
    ];

    public function peliculas()
    {
        return $this->belongsToMany(Pelicula::class);
    }
}
