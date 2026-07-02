<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Aluno;
use App\Models\Turma;
use Illuminate\Support\Facades\Hash;

class AlunoSeeder extends Seeder
{
    public function run(): void
    {
        // Busca turmas já criadas pelo TurmaSeeder
        $turma1A = Turma::where('serie', '1')->where('turma', 'A')->first();
        $turma1B = Turma::where('serie', '1')->where('turma', 'B')->first();
        $turma2A = Turma::where('serie', '2')->where('turma', 'A')->first();
        $turma3A = Turma::where('serie', '3')->where('turma', 'A')->first();

        $alunos = [
            ['name' => 'Rafael Palhares',  'email' => 'rafael@aprendercrescer.com',  'turma' => $turma1A, 'nascimento' => '2008-03-15'],
            ['name' => 'Murilo Santos',    'email' => 'murilo@aprendercrescer.com',   'turma' => $turma1A, 'nascimento' => '2008-07-22'],
            ['name' => 'Natan Ferreira',   'email' => 'natan@aprendercrescer.com',    'turma' => $turma1B, 'nascimento' => '2008-11-05'],
            ['name' => 'Tiago Almeida',    'email' => 'tiago@aprendercrescer.com',    'turma' => $turma1B, 'nascimento' => '2009-01-30'],
            ['name' => 'Beatriz Rocha',    'email' => 'beatriz@aprendercrescer.com',  'turma' => $turma2A, 'nascimento' => '2007-06-18'],
            ['name' => 'Lucas Mendes',     'email' => 'lucas@aprendercrescer.com',    'turma' => $turma2A, 'nascimento' => '2007-09-12'],
            ['name' => 'Julia Carvalho',   'email' => 'julia@aprendercrescer.com',    'turma' => $turma3A, 'nascimento' => '2006-04-25'],
            ['name' => 'Pedro Nascimento', 'email' => 'pedro@aprendercrescer.com',    'turma' => $turma3A, 'nascimento' => '2006-12-03'],
        ];

        foreach ($alunos as $dados) {
            $user = User::create([
                'name'     => $dados['name'],
                'email'    => $dados['email'],
                'password' => Hash::make('12345678'),
                'role'     => 'aluno',
            ]);

            // Matrícula gerada aqui no seeder seguindo o mesmo padrão do Model Aluno::boot()
            // Formato: AP + ano + sequencial com 4 dígitos → AP20260001
            $ano       = date('Y');
            $sequencia = Aluno::count() + 1;
            $matricula = 'AP' . $ano . str_pad($sequencia, 4, '0', STR_PAD_LEFT);

            Aluno::create([
                'user_id'         => $user->id,
                'turma_id'        => $dados['turma']?->id,
                'matricula'       => $matricula,
                'data_nascimento' => $dados['nascimento'],
            ]);
        }
    }
}
