<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ElementoOrden extends Model
{
    use HasFactory;

    protected $table = 'elemento_ordenes';

    protected $fillable = ['orden_id', 'producto_id', 'cantidad', 'monto_unitario', 'monto_total'];

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
