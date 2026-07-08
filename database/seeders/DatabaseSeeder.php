<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([

            AdminSeeder::class,

            TurmaSeeder::class,

            ProfessorSeeder::class,

            AlunoSeeder::class,

            AvisoSeeder::class,

            SalaSeeder::class,
            EquipamentoSeeder::class,

            GradeHorarioSeeder::class,

            LivroSeeder::class,

            CategoriaCantinasSeeder::class,
            ProdutoCantinaSeeder::class,
        ]);
    }
}
