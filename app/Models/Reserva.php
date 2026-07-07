<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'professor_id',
        'sala_id',
        'equipamento_id',
        'data',
        'horario_inicio',
        'horario_fim',
        'finalidade',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'date',
        ];
    }

    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class);
    }

    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeAprovadas($query)
    {
        return $query->where('status', 'aprovada');
    }
}