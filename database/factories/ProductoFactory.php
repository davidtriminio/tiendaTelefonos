<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'nombre' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'imagen' => $this->faker->word(),
            'descripcion' => $this->faker->word(),
            'precio' => $this->faker->randomFloat(),
            'activo' => $this->faker->boolean(),
            'presentado' => $this->faker->boolean(),
            'en_existencia' => $this->faker->boolean(),
            'en_venta' => $this->faker->boolean(),

            'categoria_id' => Categoria::factory(),
            'marca_id' => Marca::factory(),
        ];
    }
}
