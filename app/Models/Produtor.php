<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produtor extends Model
{
    // ESPECIFIQUE O NOME DA TABELA
    protected $table = 'produtores';
    
    protected $fillable = [
        'usuario_id', 'tipo_documento', 'documento', 'telefone', 
        'endereco', 'cidade', 'estado', 'cep'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function feiras()
    {
        return $this->hasMany(Feira::class);
    }

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
}