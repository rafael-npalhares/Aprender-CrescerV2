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
        $avisos = Aviso::where('ativo', true)
                       ->whereIn('visivel_para', ['todos', 'alunos'])
                       ->latest()->take(5)->get();

        $meusEmprestimos = Emprestimo::where('user_id', auth()->id())
                                     ->where('status', 'ativo')->get();

        return view('dashboard.aluno', compact('avisos', 'meusEmprestimos'));
    }

    public function avisos()
    {
        $avisos = Aviso::where('ativo', true)
                       ->whereIn('visivel_para', ['todos', 'alunos'])
                       ->latest()->paginate(10);

        return view('aluno.avisos', compact('avisos'));
    }

    public function horarios()
    {
        $aluno    = auth()->user()->aluno;
        $horarios = collect();

        if ($aluno && $aluno->turma_id) {
            $horarios = GradeHorario::where('turma_id', $aluno->turma_id)
                                    ->with('professor')
                                    ->orderBy('dia_semana')
                                    ->get();
        }

        return view('aluno.horarios', compact('horarios'));
    }
}