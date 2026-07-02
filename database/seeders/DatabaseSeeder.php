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
            // 1. Usuários base (admin e gerente)
            AdminSeeder::class,

            // 2. Estrutura escolar (turmas antes de alunos)
            TurmaSeeder::class,

            // 3. Professores (criam User + Professor)
            ProfessorSeeder::class,

            // 4. Alunos (dependem de turmas já existentes)
            AlunoSeeder::class,

            // 5. Comunicados (dependem de admin já existente)
            AvisoSeeder::class,

            // 6. Salas e equipamentos (independentes)
            SalaSeeder::class,
            EquipamentoSeeder::class,

            // 7. Grade de horários (depende de turmas e professores)
            GradeHorarioSeeder::class,

            // 8. Biblioteca
            LivroSeeder::class,

            // 9. Cantina (categorias antes de produtos)
            CategoriaCantinasSeeder::class,
            ProdutoCantinaSeeder::class,
        ]);
    }
}
