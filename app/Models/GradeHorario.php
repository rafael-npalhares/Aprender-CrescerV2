<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GradeHorario extends Model
{
    use HasFactory;

    protected $table = 'grade_horarios';

    protected $fillable = [
        'turma_id',
        'professor_id',
        'disciplina',
        'dia_semana',
        'aula',
    ];

    // ─── Relacionamentos ──────────────────────────────────────────────────────

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    // professor_id aponta para users.id
    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    // Retorna o horário de início da aula baseado no número
    // Referência: 1=7h00, 2=8h00, 3=9h00, 4=10h00, 5=11h00, 6=13h00
    public function getHorarioAttribute(): string
    {
        $horarios = [
            '1' => '07:00',
            '2' => '08:00',
            '3' => '09:00',
            '4' => '10:00',
            '5' => '11:00',
            '6' => '13:00',
        ];

        return $horarios[$this->aula] ?? '--:--';
    }
}