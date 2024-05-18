<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Direccion extends Model
{
    use HasFactory;

    protected $table = 'direcciones';
    protected $fillable = ['nombre', 'nombres', 'apellidos', 'telefono', 'departamento', 'ciudad', 'codigo_postal', 'colonia'];

    public function orden(): BelongsTo
    {
        return $this->belongsTo(Orden::class);
    }
}
