<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    protected $fillable = ['consumidor_id', 'feira_id'];

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
        return $this->hasMany(ItemCarrinho::class);
    }

    public function getTotalAttribute()
    {
        return $this->items->sum('subtotal');
    }
}