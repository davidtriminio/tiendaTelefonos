<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('elemento_ordenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')->constrained('ordenes')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->integer('cantidad')->default(1);
            $table->decimal('monto_unitario', 10,2)->nullable();
            $table->decimal('monto_total',10,2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elemento_ordenes');
    }
};
