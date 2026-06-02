<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Turma;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    public function index()
    {
        $turmas = Turma::orderBy('serie')->orderBy('turma')->get();
        return view('admin.turmas.index', compact('turmas'));
    }

    public function create()
    {
        return view('admin.turmas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'serie'      => 'required|in:1,2,3',
            'turma'      => 'required|string|max:5',
            'turno'      => 'required|in:manha,tarde,noite',
            'ano_letivo' => 'required|digits:4',
        ]);

        Turma::create($request->only('serie', 'turma', 'turno', 'ano_letivo'));

        return redirect()->route('admin.turmas.index')
                         ->with('sucesso', 'Turma criada!');
    }

    public function edit(Turma $turma)
    {
        return view('admin.turmas.edit', compact('turma'));
    }

    public function update(Request $request, Turma $turma)
    {
        $request->validate([
            'serie'      => 'required|in:1,2,3',
            'turma'      => 'required|string|max:5',
            'turno'      => 'required|in:manha,tarde,noite',
            'ano_letivo' => 'required|digits:4',
            'ativa'      => 'boolean',
        ]);

        $turma->update($request->only('serie', 'turma', 'turno', 'ano_letivo', 'ativa'));

        return redirect()->route('admin.turmas.index')
                         ->with('sucesso', 'Turma atualizada!');
    }

    public function destroy(Turma $turma)
    {
        $turma->delete();

        return redirect()->route('admin.turmas.index')
                         ->with('sucesso', 'Turma removida!');
    }
}