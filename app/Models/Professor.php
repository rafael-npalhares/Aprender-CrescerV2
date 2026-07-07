<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Professor extends Model
{
    use HasFactory;

    protected $table = 'professores';

    protected $fillable = [
        'user_id',
        'disciplina',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'professor_id', 'user_id');
    }
    public function gradeHorarios()
    {
        return $this->hasMany(GradeHorario::class, 'professor_id', 'user_id');
    }
}