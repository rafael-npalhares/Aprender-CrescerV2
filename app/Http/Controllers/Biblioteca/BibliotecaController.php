<?php

namespace App\Http\Controllers\Biblioteca;

use App\Http\Controllers\Controller;
use App\Models\Livro;
use App\Models\Emprestimo;
use Illuminate\Http\Request;

class BibliotecaController extends Controller
{
    // Lista o acervo de livros
    public function index()
    {
        $livros = Livro::orderBy('titulo')->paginate(12);
        return view('biblioteca.index', compact('livros'));
    }

    // Busca livros por título ou autor
    public function buscar(Request $request)
    {
        $livros = Livro::where('titulo', 'like', '%' . $request->q . '%')
                       ->orWhere('autor', 'like', '%' . $request->q . '%')
                       ->paginate(12);

        return view('biblioteca.index', compact('livros'));
    }

    // Empresta um livro (RN-08: máximo 2 empréstimos simultâneos)
    public function emprestar(Request $request)
    {
        $request->validate(['livro_id' => 'required|exists:livros,id']);

        $emprestimosAtivos = Emprestimo::where('user_id', auth()->id())
                                       ->where('status', 'ativo')->count();

        if ($emprestimosAtivos >= 2) {
            return back()->with('erro', 'Você já tem 2 livros emprestados.');
        }

        $livro = Livro::findOrFail($request->livro_id);

        if ($livro->qtd_disponivel <= 0) {
            return back()->with('erro', 'Livro indisponível no momento.');
        }

        Emprestimo::create([
            'user_id'         => auth()->id(),
            'livro_id'        => $livro->id,
            'data_emprestimo' => now(),
            'status'          => 'ativo',
        ]);

        $livro->decrement('qtd_disponivel');

        return back()->with('sucesso', 'Livro emprestado!');
    }

    // Renova empréstimo (RN-09: máximo 5 renovações)
    public function renovar(Emprestimo $emp)
    {
        if ($emp->renovacoes >= 5) {
            return back()->with('erro', 'Limite de 5 renovações atingido.');
        }

        $emp->increment('renovacoes');

        return back()->with('sucesso', 'Empréstimo renovado!');
    }

    // Devolução de livro
    public function devolver(Emprestimo $emp)
    {
        $emp->update([
            'status'         => 'devolvido',
            'data_devolucao' => now(),
        ]);

        $emp->livro->increment('qtd_disponivel');

        return back()->with('sucesso', 'Livro devolvido!');
    }

    // Meus empréstimos (professor e aluno)
    public function meusEmprestimos()
    {
        $emprestimos = Emprestimo::where('user_id', auth()->id())
                                 ->with('livro')->latest()->get();

        return view('biblioteca.emprestimos', compact('emprestimos'));
    }

    // Admin — formulário de cadastro de livro
    public function createLivro()
    {
        return view('admin.biblioteca.create');
    }

    // Admin — salva novo livro no acervo
    public function storeLivro(Request $request)
    {
        $request->validate([
            'titulo'         => 'required|string|max:300',
            'autor'          => 'required|string|max:200',
            'qtd_total'      => 'required|integer|min:1',
            'qtd_disponivel' => 'required|integer|min:0',
        ]);

        Livro::create($request->all());

        return redirect()->route('admin.biblioteca.index')
                         ->with('sucesso', 'Livro adicionado!');
    }
}