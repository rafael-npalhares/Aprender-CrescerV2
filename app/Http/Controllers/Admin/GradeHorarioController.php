<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GradeHorario;
use App\Models\Turma;
use App\Models\User;
use Illuminate\Http\Request;

class GradeHorarioController extends Controller
{
    public function index()
    {
        $turmas   = Turma::where('ativa', true)->get();
        $horarios = GradeHorario::with(['turma', 'professor'])->get();

        return view('admin.horarios.index', compact('turmas', 'horarios'));
    }

    public function create()
    {
        $turmas      = Turma::where('ativa', true)->get();
        $professores = User::where('role', 'professor')->orderBy('name')->get();

        return view('admin.horarios.create', compact('turmas', 'professores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'turma_id'     => 'required|exists:turmas,id',
            'professor_id' => 'required|exists:users,id',
            'disciplina'   => 'required|string|max:200',
            'dia_semana'   => 'required|in:segunda,terca,quarta,quinta,sexta',
            'aula'         => 'required|in:1,2,3,4,5,6',
        ]);

        GradeHorario::create($request->all());

        return redirect()->route('admin.grade.index')
                         ->with('sucesso', 'Horário adicionado!');
    }

    public function edit(GradeHorario $grade)
    {
        $turmas      = Turma::where('ativa', true)->get();
        $professores = User::where('role', 'professor')->orderBy('name')->get();

        return view('admin.horarios.edit', compact('grade', 'turmas', 'professores'));
    }

    public function update(Request $request, GradeHorario $grade)
    {
        $request->validate([
            'turma_id'     => 'required|exists:turmas,id',
            'professor_id' => 'required|exists:users,id',
            'disciplina'   => 'required|string|max:200',
            'dia_semana'   => 'required|in:segunda,terca,quarta,quinta,sexta',
            'aula'         => 'required|in:1,2,3,4,5,6',
        ]);

        $grade->update($request->all());

        return redirect()->route('admin.grade.index')
                         ->with('sucesso', 'Horário atualizado!');
    }

    public function destroy(GradeHorario $grade)
    {
        $grade->delete();

        return redirect()->route('admin.grade.index')
                         ->with('sucesso', 'Horário removido!');
    }
}