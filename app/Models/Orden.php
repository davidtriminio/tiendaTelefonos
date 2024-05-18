<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Orden extends Model
{
    use HasFactory;

    protected $table = 'ordenes';
    protected $fillable = [
        'user_id',
        'total_final',
        'metodo_pago',
        'estado_pago',
        'estado_envio',
        'metodo_envio',
        'moneda',
        'monto_compra',
        'notas',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function elementos()
    {
        return $this->hasMany(ElementoOrden::class, 'orden_id');
    }

    public function direccion()
    {
        return $this->hasOne(Direccion::class);
    }

}
