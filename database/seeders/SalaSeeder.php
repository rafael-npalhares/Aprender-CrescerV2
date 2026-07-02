<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sala;

class SalaSeeder extends Seeder
{
    public function run(): void
    {
        $salas = [
            'Sala 01 — Bloco A',
            'Sala 02 — Bloco A',
            'Sala 03 — Bloco A',
            'Sala 04 — Bloco B',
            'Sala 05 — Bloco B',
            'Laboratório de Informática',
            'Laboratório de Ciências',
            'Auditório',
            'Sala de Reuniões',
            'Biblioteca',
        ];

        foreach ($salas as $nome) {
            Sala::create([
                'nome'       => $nome,
                'disponivel' => true,
            ]);
        }
    }
}
