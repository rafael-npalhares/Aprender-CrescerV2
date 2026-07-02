<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = [
        'serie',
        'turma',
        'turno',
        'ano_letivo',
        'ativa',
    ];

    protected function casts(): array
    {
        return [
            'ativa' => 'boolean',
        ];
    }

    // ─── Relacionamentos ──────────────────────────────────────────────────────

    public function alunos()
    {
        return $this->hasMany(Aluno::class);
    }

    public function gradeHorarios()
    {
        return $this->hasMany(GradeHorario::class);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    // Retorna o nome completo formatado da turma, ex: "1º Ano A — Manhã"
    public function getNomeCompletoAttribute(): string
    {
        $turnos = ['manha' => 'Manhã', 'tarde' => 'Tarde', 'noite' => 'Noite'];
        return "{$this->serie}º Ano {$this->turma} — " . ($turnos[$this->turno] ?? $this->turno);
    }
}