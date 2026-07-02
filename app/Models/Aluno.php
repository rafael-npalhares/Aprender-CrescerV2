<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'turma_id',
        'matricula',
        'data_nascimento',
    ];

    protected function casts(): array
    {
        return [
            'data_nascimento' => 'date',
        ];
    }

    // ─── Geração automática de matrícula ─────────────────────────────────────
    // Formato: AP + ano_atual + sequencial com 4 dígitos
    // Exemplo: AP20260001, AP20260002, AP20260003 ...
    // Executado automaticamente antes de cada INSERT

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Aluno $aluno) {
            if (empty($aluno->matricula)) {
                $ano       = date('Y');
                $ultimo    = static::whereRaw("matricula LIKE 'AP{$ano}%'")->count();
                $sequencia = $ultimo + 1;
                $aluno->matricula = 'AP' . $ano . str_pad($sequencia, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    // ─── Relacionamentos ──────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}