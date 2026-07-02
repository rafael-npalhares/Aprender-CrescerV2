<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use App\Models\Aviso;
use App\Models\GradeHorario;
use App\Models\Emprestimo;

class AlunoController extends Controller
{
    public function index()
    {
        $aluno = auth()->user()->aluno()->with('turma')->first();

        // Avisos recentes para a listagem normal da dashboard
        $avisos = Aviso::where('ativo', true)
                       ->whereIn('visivel_para', ['todos', 'alunos'])
                       ->latest()
                       ->take(5)
                       ->get();

        // Avisos fixados — exibidos no modal a cada login
        $avisosFixados = Aviso::where('ativo', true)
                              ->where('fixado', true)
                              ->whereIn('visivel_para', ['todos', 'alunos'])
                              ->latest()
                              ->get();

        $meusEmprestimos = Emprestimo::where('user_id', auth()->id())
                                     ->where('status', 'ativo')
                                     ->with('livro')
                                     ->get();

        return view('dashboard.aluno', compact('aluno', 'avisos', 'avisosFixados', 'meusEmprestimos'));
    }

    public function avisos()
    {
        $avisos = Aviso::where('ativo', true)
                       ->whereIn('visivel_para', ['todos', 'alunos'])
                       ->latest()
                       ->paginate(10);

        return view('aluno.avisos', compact('avisos'));
    }

    public function horarios()
    {
        $aluno = auth()->user()->aluno()->with('turma')->first();
        $turma = $aluno?->turma;
        $grade = collect();
    
        if ($aluno && $aluno->turma_id) {
            $grade = GradeHorario::where('turma_id', $aluno->turma_id)
                                 ->with('professor')
                                 ->orderBy('dia_semana')
                                 ->get();
        }
    
        return view('aluno.horarios', compact('grade', 'turma'));
    }
}