<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function alunos()
    {
        return $this->hasMany(Aluno::class);
    }

    public function gradeHorarios()
    {
        return $this->hasMany(GradeHorario::class);
    }
}