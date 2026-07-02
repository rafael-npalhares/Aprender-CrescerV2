<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Professor;
use Illuminate\Support\Facades\Hash;

class ProfessorSeeder extends Seeder
{
    public function run(): void
    {
        $professores = [
            ['name' => 'Prof. Carlos Silva',    'email' => 'carlos@aprendercrescer.com',    'disciplina' => 'Matemática'],
            ['name' => 'Prof. Ana Souza',       'email' => 'ana@aprendercrescer.com',        'disciplina' => 'Português'],
            ['name' => 'Prof. Roberto Lima',    'email' => 'roberto@aprendercrescer.com',    'disciplina' => 'História'],
            ['name' => 'Prof. Fernanda Costa',  'email' => 'fernanda@aprendercrescer.com',   'disciplina' => 'Ciências'],
            ['name' => 'Prof. Marcos Oliveira', 'email' => 'marcos@aprendercrescer.com',     'disciplina' => 'Educação Física'],
        ];

        foreach ($professores as $dados) {
            $user = User::create([
                'name'     => $dados['name'],
                'email'    => $dados['email'],
                'password' => Hash::make('12345678'),
                'role'     => 'professor',
            ]);

            Professor::create([
                'user_id'    => $user->id,
                'disciplina' => $dados['disciplina'],
            ]);
        }
    }
}
