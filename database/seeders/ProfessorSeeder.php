<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Professor;

class ProfessorSeeder extends Seeder
{
    public function run(): void
    {
        $professor = User::create([
            'name'     => 'Natan',
            'email'    => 'natan@aprendercrescer.com',
            'password' => bcrypt('12345678'),
            'role'     => 'professor',
        ]);
        
        Professor::create([
            'user_id'    => $professor->id,
            'disciplina' => 'Matemática',
        ]);
    }
}
