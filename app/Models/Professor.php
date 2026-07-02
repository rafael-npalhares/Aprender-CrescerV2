<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Professor extends Model
{
    use HasFactory;

    // Necessário porque o Laravel infere 'professors' mas a tabela se chama 'professores'
    protected $table = 'professores';

    protected $fillable = [
        'user_id',
        'disciplina',
    ];

    // ─── Relacionamentos ──────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Reservas feitas por este professor
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'professor_id', 'user_id');
    }

    // Aulas na grade de horários
    public function gradeHorarios()
    {
        return $this->hasMany(GradeHorario::class, 'professor_id', 'user_id');
    }
}