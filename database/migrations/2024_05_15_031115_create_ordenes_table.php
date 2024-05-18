<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users') ->cascadeOnDelete();
            $table->decimal('total_final', 10,2)->nullable();
            $table->string('metodo_pago')->nullable();
            $table->string('moneda')->nullable();
            $table->string('estado_pago')->nullable();
            $table->enum('estado_envio', ['nuevo', 'procesado', 'enviado', 'entregado', 'cancelado'])->default('nuevo');
            $table->decimal('monto_compra', 10,2)->nullable();
            $table->string('metodo_envio')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};
