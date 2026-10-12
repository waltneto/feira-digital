<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'consumidor_id', 'feira_id', 'codigo_pedido', 'status', 'total', 'codigo_qr', 'horario_retirada'
    ];

    public function consumidor()
    {
        return $this->belongsTo(Consumidor::class);
    }

    public function feira()
    {
        return $this->belongsTo(Feira::class);
    }

    public function items()
    {
        return $this->hasMany(ItemPedido::class);
    }
}