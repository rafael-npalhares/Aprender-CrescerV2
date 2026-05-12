<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'disponivel',
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}