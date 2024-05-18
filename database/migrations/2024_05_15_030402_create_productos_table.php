<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->cascadeOnDelete();
            $table->foreignId('marca_id')->constrained('marcas')->cascadeOnDelete();
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->longText('imagen')->nullable();
            $table->longText('descripcion')->nullable();
            $table->decimal('precio', 10,2);
            $table->boolean('activo')->default(true);
            $table->boolean('presentado')->default(true);
            $table->boolean('en_existencia')->default(true);
            $table->boolean('en_venta')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
