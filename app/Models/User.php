<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'name', 'email', 'password', 'is_admin',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function produtor()
    {
        return $this->hasOne(Produtor::class, 'usuario_id');
    }

    public function consumidor()
    {
        return $this->hasOne(Consumidor::class, 'usuario_id');
    }

    public function isProdutor()
    {
        return $this->produtor !== null;
    }

    public function isConsumidor()
    {
        return $this->consumidor !== null;
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }
}