<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GradeHorario;
use App\Models\Turma;
use App\Models\User;
use Illuminate\Http\Request;

class GradeHorarioController extends Controller
{
    public function index(Request $request)
    {
        $turmas = Turma::where('ativa', true)->orderBy('serie')->orderBy('turma')->get();

        $turmaSelecionada = null;
        $horarios         = collect();

        if ($request->turma_id) {
            $turmaSelecionada = Turma::find($request->turma_id);

            if ($turmaSelecionada) {
                $horarios = GradeHorario::with('professor')
                                        ->where('turma_id', $turmaSelecionada->id)
                                        ->get();
            }
        }

        return view('admin.horarios.index', compact('turmas', 'horarios', 'turmaSelecionada'));
    }

    public function create(Request $request)
    {
        $turmas      = Turma::where('ativa', true)->get();
        $professores = User::where('role', 'professor')->orderBy('name')->get();

        $preSelecao = [
            'turma_id'   => $request->turma_id,
            'dia_semana' => $request->dia_semana,
            'aula'       => $request->aula,
        ];

        return view('admin.horarios.create', compact('turmas', 'professores', 'preSelecao'));
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

        GradeHorario::create($request->only('turma_id', 'professor_id', 'disciplina', 'dia_semana', 'aula'));

        return redirect()->route('admin.grade.index', ['turma_id' => $request->turma_id])
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

        $grade->update($request->only('turma_id', 'professor_id', 'disciplina', 'dia_semana', 'aula'));

        return redirect()->route('admin.grade.index', ['turma_id' => $grade->turma_id])
                         ->with('sucesso', 'Horário atualizado!');
    }

    public function destroy(GradeHorario $grade)
    {
        $turmaId = $grade->turma_id;
        $grade->delete();

        return redirect()->route('admin.grade.index', ['turma_id' => $turmaId])
                         ->with('sucesso', 'Horário removido!');
    }
}