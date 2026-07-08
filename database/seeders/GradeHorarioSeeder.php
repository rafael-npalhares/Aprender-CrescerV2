<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GradeHorario;
use App\Models\Turma;
use App\Models\Professor;

class GradeHorarioSeeder extends Seeder
{
    public function run(): void
    {
        $turma1A = Turma::where('serie', '1')->where('turma', 'A')->first();

        $profCarlos   = Professor::whereHas('user', fn($q) => $q->where('email', 'carlos@aprendercrescer.com'))->first();
        $profAna      = Professor::whereHas('user', fn($q) => $q->where('email', 'ana@aprendercrescer.com'))->first();
        $profRoberto  = Professor::whereHas('user', fn($q) => $q->where('email', 'roberto@aprendercrescer.com'))->first();
        $profFernanda = Professor::whereHas('user', fn($q) => $q->where('email', 'fernanda@aprendercrescer.com'))->first();
        $profMarcos   = Professor::whereHas('user', fn($q) => $q->where('email', 'marcos@aprendercrescer.com'))->first();

        $grade = [
         
            ['turma' => $turma1A, 'professor' => $profCarlos,   'disciplina' => 'Matemática',       'dia' => 'segunda', 'aula' => '1'],
            ['turma' => $turma1A, 'professor' => $profCarlos,   'disciplina' => 'Matemática',       'dia' => 'segunda', 'aula' => '2'],
            ['turma' => $turma1A, 'professor' => $profAna,      'disciplina' => 'Português',        'dia' => 'segunda', 'aula' => '3'],
            ['turma' => $turma1A, 'professor' => $profAna,      'disciplina' => 'Português',        'dia' => 'segunda', 'aula' => '4'],
       
            ['turma' => $turma1A, 'professor' => $profFernanda, 'disciplina' => 'Ciências',         'dia' => 'terca',   'aula' => '1'],
            ['turma' => $turma1A, 'professor' => $profFernanda, 'disciplina' => 'Ciências',         'dia' => 'terca',   'aula' => '2'],
            ['turma' => $turma1A, 'professor' => $profRoberto,  'disciplina' => 'História',         'dia' => 'terca',   'aula' => '3'],
            ['turma' => $turma1A, 'professor' => $profRoberto,  'disciplina' => 'História',         'dia' => 'terca',   'aula' => '4'],
         
            ['turma' => $turma1A, 'professor' => $profCarlos,   'disciplina' => 'Matemática',       'dia' => 'quarta',  'aula' => '1'],
            ['turma' => $turma1A, 'professor' => $profAna,      'disciplina' => 'Português',        'dia' => 'quarta',  'aula' => '2'],
            ['turma' => $turma1A, 'professor' => $profMarcos,   'disciplina' => 'Educação Física',  'dia' => 'quarta',  'aula' => '3'],
            ['turma' => $turma1A, 'professor' => $profMarcos,   'disciplina' => 'Educação Física',  'dia' => 'quarta',  'aula' => '4'],
         
            ['turma' => $turma1A, 'professor' => $profFernanda, 'disciplina' => 'Ciências',         'dia' => 'quinta',  'aula' => '1'],
            ['turma' => $turma1A, 'professor' => $profRoberto,  'disciplina' => 'História',         'dia' => 'quinta',  'aula' => '2'],
            ['turma' => $turma1A, 'professor' => $profCarlos,   'disciplina' => 'Matemática',       'dia' => 'quinta',  'aula' => '3'],
            ['turma' => $turma1A, 'professor' => $profAna,      'disciplina' => 'Português',        'dia' => 'quinta',  'aula' => '4'],
  
            ['turma' => $turma1A, 'professor' => $profAna,      'disciplina' => 'Português',        'dia' => 'sexta',   'aula' => '1'],
            ['turma' => $turma1A, 'professor' => $profMarcos,   'disciplina' => 'Educação Física',  'dia' => 'sexta',   'aula' => '2'],
            ['turma' => $turma1A, 'professor' => $profFernanda, 'disciplina' => 'Ciências',         'dia' => 'sexta',   'aula' => '3'],
            ['turma' => $turma1A, 'professor' => $profRoberto,  'disciplina' => 'História',         'dia' => 'sexta',   'aula' => '4'],
        ];

        foreach ($grade as $item) {
            if (!$item['turma'] || !$item['professor']) continue;

            GradeHorario::create([
                'turma_id'     => $item['turma']->id,
                'professor_id' => $item['professor']->user_id,
                'disciplina'   => $item['disciplina'],
                'dia_semana'   => $item['dia'],
                'aula'         => $item['aula'],
            ]);
        }
    }
}
