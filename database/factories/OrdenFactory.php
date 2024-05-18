<?php

namespace Database\Factories;

use App\Models\Orden;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrdenFactory extends Factory
{
    protected $model = Orden::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'total_final' => $this->faker->randomFloat(),
            'metodo_pago' => $this->faker->word(),
            'estado_pago' => $this->faker->word(),
            'estado_envio' => $this->faker->word(),
            'moneda' => $this->faker->word(),
            'precio' => $this->faker->randomFloat(),
            'monto_compra' => $this->faker->randomFloat(),
            'notas' => $this->faker->word(),

            'user_id' => User::factory(),
        ];
    }
}
