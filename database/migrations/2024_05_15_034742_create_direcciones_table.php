<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')->constrained('ordenes')->cascadeOnDelete();
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('telefono')->nullable();
            $table->string('colonia')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('departamento')->nullable();
            $table->string('codigo_postal')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};
