<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feira extends Model
{
    protected $fillable = [
        'nome', 'descricao', 'data_inicio', 'data_fim', 'endereco', 'cidade', 'estado', 'cep', 'status', 'ativa'
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
    ];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'feira_produto')->withPivot('quantidade_disponivel');
    }

    public function carrinhos()
    {
        return $this->hasMany(Carrinho::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}