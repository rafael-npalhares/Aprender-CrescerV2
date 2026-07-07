<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isProfessor(): bool
    {
        return $this->role === 'professor';
    }

    public function isAluno(): bool
    {
        return $this->role === 'aluno';
    }

    public function isGerente(): bool
    {
        return $this->role === 'gerente';
    }

    public function aluno()
    {
        return $this->hasOne(Aluno::class);
    }

    public function professor()
    {
        return $this->hasOne(Professor::class);
    }

    public function avisos()
    {
        return $this->hasMany(Aviso::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'professor_id');
    }

    public function emprestimos()
    {
        return $this->hasMany(Emprestimo::class);
    }

    public function pedidosCantina()
    {
        return $this->hasMany(PedidoCantina::class);
    }

    public function gradeHorarios()
    {
        return $this->hasMany(GradeHorario::class, 'professor_id');
    }
}