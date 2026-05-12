<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeHorario extends Model
{
    use HasFactory;

    protected $fillable = [
        'turma_id',
        'professor_id',
        'disciplina',
        'dia_semana',
        'aula',
    ];

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }
}