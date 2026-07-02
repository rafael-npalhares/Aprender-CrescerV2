<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Turma;

class TurmaSeeder extends Seeder
{
    public function run(): void
    {
        $turmas = [
            // 1º Ano
            ['serie' => '1', 'turma' => 'A', 'turno' => 'manha',  'ano_letivo' => 2026, 'ativa' => true],
            ['serie' => '1', 'turma' => 'B', 'turno' => 'tarde',  'ano_letivo' => 2026, 'ativa' => true],
            ['serie' => '1', 'turma' => 'C', 'turno' => 'noite',  'ano_letivo' => 2026, 'ativa' => true],
            // 2º Ano
            ['serie' => '2', 'turma' => 'A', 'turno' => 'manha',  'ano_letivo' => 2026, 'ativa' => true],
            ['serie' => '2', 'turma' => 'B', 'turno' => 'tarde',  'ano_letivo' => 2026, 'ativa' => true],
            // 3º Ano
            ['serie' => '3', 'turma' => 'A', 'turno' => 'manha',  'ano_letivo' => 2026, 'ativa' => true],
            ['serie' => '3', 'turma' => 'B', 'turno' => 'noite',  'ano_letivo' => 2026, 'ativa' => true],
        ];

        foreach ($turmas as $turma) {
            Turma::create($turma);
        }
    }
}
