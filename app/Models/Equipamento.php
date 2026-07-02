<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'disponivel',
    ];

    protected function casts(): array
    {
        return [
            'disponivel' => 'boolean',
        ];
    }

    // ─── Relacionamentos ──────────────────────────────────────────────────────

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}