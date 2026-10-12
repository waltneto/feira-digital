<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'produtor_id', 'nome', 'descricao', 'preco', 'unidade_medida', 'foto', 'organico', 'disponivel'
    ];

    public function produtor()
    {
        return $this->belongsTo(Produtor::class);
    }

    public function feiras()
    {
        return $this->belongsToMany(Feira::class, 'feira_produto')->withPivot('quantidade_disponivel');
    }
}