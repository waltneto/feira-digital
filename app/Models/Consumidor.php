<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumidor extends Model
{
    protected $table = 'consumidores';

    protected $fillable = ['usuario_id', 'cpf', 'telefone'];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function carrinhos()
    {
        return $this->hasMany(Carrinho::class);
    }
}