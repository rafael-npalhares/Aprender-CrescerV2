<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aviso;
use Illuminate\Http\Request;

class AvisoController extends Controller
{
    public function index()
    {
        $avisos = Aviso::with('autor')->latest()->paginate(10);
        return view('admin.avisos.index', compact('avisos'));
    }

    public function create()
    {
        return view('admin.avisos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'         => 'required|string|max:200',
            'conteudo'       => 'required|string',
            'visivel_para'   => 'required|in:todos,alunos,professores',
            'data_expiracao' => 'nullable|date|after:today',
            'fixado'         => 'boolean',
        ]);

        Aviso::create([
            'user_id'        => auth()->id(),
            'titulo'         => $request->titulo,
            'conteudo'       => $request->conteudo,
            'visivel_para'   => $request->visivel_para,
            'data_expiracao' => $request->data_expiracao,
            'fixado'         => $request->boolean('fixado'),
        ]);

        return redirect()->route('admin.avisos.index')
                         ->with('sucesso', 'Aviso publicado!');
    }

    public function edit(Aviso $aviso)
    {
        return view('admin.avisos.edit', compact('aviso'));
    }

    public function update(Request $request, Aviso $aviso)
    {
        $request->validate([
            'titulo'       => 'required|string|max:200',
            'conteudo'     => 'required|string',
            'visivel_para' => 'required|in:todos,alunos,professores',
        ]);

        $aviso->update($request->only('titulo', 'conteudo', 'visivel_para', 'data_expiracao', 'fixado', 'ativo'));

        return redirect()->route('admin.avisos.index')
                         ->with('sucesso', 'Aviso atualizado!');
    }

    public function destroy(Aviso $aviso)
    {
        $aviso->delete();

        return redirect()->route('admin.avisos.index')
                         ->with('sucesso', 'Aviso removido!');
    }
}