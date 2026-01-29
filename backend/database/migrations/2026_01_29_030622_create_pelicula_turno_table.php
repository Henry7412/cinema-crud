<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelicula_turno', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelicula_id')->constrained('peliculas')->cascadeOnDelete();
            $table->foreignId('turno_id')->constrained('turnos')->cascadeOnDelete();
            $table->unique(['pelicula_id', 'turno_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelicula_turno');
    }
};
