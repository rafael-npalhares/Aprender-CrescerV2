<?php

namespace App\Http\Controllers\Biblioteca;

use App\Http\Controllers\Controller;
use App\Models\Livro;
use App\Models\Emprestimo;
use Illuminate\Http\Request;

class BibliotecaController extends Controller
{
    public function index()
    {
        $livros = Livro::orderBy('titulo')->paginate(12);
        return view('biblioteca.index', compact('livros'));
    }

    public function buscar(Request $request)
    {
        $livros = Livro::where('titulo', 'like', '%' . $request->q . '%')
                       ->orWhere('autor', 'like', '%' . $request->q . '%')
                       ->paginate(12);

        return view('biblioteca.index', compact('livros'));
    }

    public function emprestar(Request $request)
    {
        $request->validate(['livro_id' => 'required|exists:livros,id']);
    
        $emprestimosAtivos = Emprestimo::where('user_id', auth()->id())
                                       ->where('status', 'ativo')
                                       ->count();
    
        if ($emprestimosAtivos >= 2) {
            return back()->with('erro', 'Você já tem 2 livros emprestados.');
        }
    
        $livro = Livro::findOrFail($request->livro_id);
    
        if ($livro->qtd_disponivel <= 0) {
            return back()->with('erro', 'Livro indisponível no momento.');
        }
    
        Emprestimo::create([
            'user_id'                  => auth()->id(),
            'livro_id'                 => $livro->id,
            'data_emprestimo'          => now(),
            'data_prevista_devolucao'  => now()->addDays(15), 
            'status'                   => 'ativo',
        ]);
    
        $livro->decrement('qtd_disponivel');
    
        return back()->with('sucesso', 'Livro emprestado!');
    }

    public function renovar(Emprestimo $emp)
    {
        if ($emp->user_id !== auth()->id()) {
            abort(403, 'Ação não autorizada.');
        }

        if ($emp->renovacoes >= 5) {
            return back()->with('erro', 'Limite de 5 renovações atingido.');
        }

        $emp->increment('renovacoes');

        return back()->with('sucesso', 'Empréstimo renovado!');
    }

    public function devolver(Emprestimo $emp)
{
    
    $emp->update([
        'status'         => 'devolvido',
        'data_devolucao' => now(),
    ]);

    $emp->livro->increment('qtd_disponivel');

    return back()->with('sucesso', 'Livro devolvido!');
}

   public function meusEmprestimos()
{
    $emprestimos = Emprestimo::where('user_id', auth()->id())
                             ->with('livro')
                             ->latest()
                             ->paginate(10);

    return view('biblioteca.emprestimos', compact('emprestimos'));
}

    public function createLivro()
    {
        return view('admin.biblioteca.create');
    }

    public function storeLivro(Request $request)
    {
        $request->validate([
            'titulo'    => 'required|string|max:300',
            'autor'     => 'required|string|max:200',
            'qtd_total' => 'required|integer|min:1',
        ]);

        Livro::create([
            'titulo'         => $request->titulo,
            'autor'          => $request->autor,
            'qtd_total'      => $request->qtd_total,
            'qtd_disponivel' => $request->qtd_total, 
        ]);

        return redirect()->route('admin.biblioteca.index')
                         ->with('sucesso', 'Livro adicionado!');
    }

    public function editLivro(Livro $livro)
    {
        return view('admin.biblioteca.edit', compact('livro'));
    }

    public function updateLivro(Request $request, Livro $livro)
    {
        $emprestados = $livro->qtd_total - $livro->qtd_disponivel;

        $request->validate([
            'titulo'    => 'required|string|max:300',
            'autor'     => 'required|string|max:200',
            'qtd_total' => 'required|integer|min:' . $emprestados,
        ]);

        $diferenca = $request->qtd_total - $livro->qtd_total;

        $livro->update([
            'titulo'         => $request->titulo,
            'autor'          => $request->autor,
            'qtd_total'      => $request->qtd_total,
            'qtd_disponivel' => $livro->qtd_disponivel + $diferenca,
        ]);

        return redirect()->route('admin.biblioteca.index')
                         ->with('sucesso', 'Livro atualizado!');
    }

    public function destroyLivro(Livro $livro)
    {
        $livro->delete();

        return redirect()->route('admin.biblioteca.index')
                         ->with('sucesso', 'Livro removido!');
    }

    public function emprestimos()
    {
        $emprestimos = Emprestimo::with(['usuario', 'livro'])->latest()->paginate(15);
        return view('admin.biblioteca.emprestimos', compact('emprestimos')); 
    }
    
    public function showLivro(Livro $livro)
{
    $emprestimosAtivos = collect();

    if (auth()->user()->isAdmin()) {
        $emprestimosAtivos = Emprestimo::where('livro_id', $livro->id)
                                       ->where('status', '!=', 'devolvido')
                                       ->with('usuario')
                                       ->latest()
                                       ->get();
    }

    return view('biblioteca.show', compact('livro', 'emprestimosAtivos'));
}
}