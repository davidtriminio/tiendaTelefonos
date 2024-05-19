<?php

namespace App\Livewire;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Producto;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

class ProductosPage extends Component
{
    #[Title('Productos - Triminios Shop')]
    #[Url]
    public $categorias_seleccionadas = [];

    #[Url]
    public $marcas_seleccionadas =[];

    #[Url]
    public $en_existencia;

    #[Url]
    public $en_venta;
    #[Url]
    public $rango_precio = 35000;

    #[Url]
    public $sort = 'recientes';


    public function render()
    {

        $productosConsulta = Producto::where('activo', 1);

        if (!empty($this->categorias_seleccionadas)) {
            $productosConsulta->whereIn('categoria_id', $this->categorias_seleccionadas);
        }

        if(!empty($this->marcas_seleccionadas)){
            $productosConsulta -> whereIn('marca_id', $this->marcas_seleccionadas);
        }

        if ($this->en_existencia){
            $productosConsulta ->where('en_existencia', 1);
        }

        if($this->en_venta){
            $productosConsulta -> where('en_existencia',1);
        }

        if ($this->rango_precio){
            $productosConsulta -> whereBetween('precio', [0, $this->rango_precio]);
        }

        if ($this->sort == 'recientes'){
            $productosConsulta -> latest();
        }

        if ($this->sort == 'precios'){
            $productosConsulta -> orderBy('precio');
        }

        return view('livewire.productos-page',
            ['productos' => $productosConsulta->paginate(6),
                'categorias' => Categoria::where('disponibilidad', 1)->get(),
                'marcas' => Marca::where('disponibilidad', 1)->get(['id', 'nombre', 'slug'])
            ]);
    }
}
