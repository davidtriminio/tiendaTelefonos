<?php

namespace Database\Factories;

use App\Models\Marca;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MarcaFactory extends Factory
{
    protected $model = Marca::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'nombre' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'imagen' => $this->faker->image(),
            'disponibilidad' => $this->faker->boolean(),
        ];
    }
}
