<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaCantina;

class CategoriaCantinasSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Lanche',
            'Refeição',
            'Bebida',
            'Sobremesa',
            'Salgado',
            'Fruta',
        ];

        foreach ($categorias as $nome) {
            CategoriaCantina::create(['nome' => $nome]);
        }
    }
}
