<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['categoria_id',
    'marca_id',
    'nombre',
    'slug',
    'imagen',
    'descripcion',
    'precio',
    'activo',
    'presentado',
    'en_existencia',
    'en_venta',];

    protected $casts = ['imagen' => 'array'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function elementosOrden()
    {
        return $this->hasMany(ElementoOrdenes::class, 'producto_id');
    }
}
