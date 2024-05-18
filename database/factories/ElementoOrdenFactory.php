<?php

namespace Database\Factories;

use App\Models\ElementoOrden;
use App\Models\Orden;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ElementoOrdenFactory extends Factory
{
    protected $model = ElementoOrden::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'cantidad' => $this->faker->randomNumber(),
            'monto_unitario' => $this->faker->randomFloat(),
            'monto_total' => $this->faker->randomFloat(),

            'orden_id' => Orden::factory(),
            'producto_id' => Producto::factory(),
        ];
    }
}
