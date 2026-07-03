<?php

namespace App\Http\Controllers\Cantina;

use App\Http\Controllers\Controller;
use App\Models\ProdutoCantina;
use App\Models\PedidoCantina;
use App\Models\ItensPedidoCantina;
use App\Models\CategoriaCantina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CantinaController extends Controller
{
    private const ESTOQUE_LIMITE_BAIXO = 5;

    // ─── Admin ───────────────────────────────────────────────────────────────

    // Painel admin: vê todos os produtos (ativos e inativos) para gerenciar
    public function adminIndex()
    {
        $produtos = ProdutoCantina::with('categoria')
            ->orderBy('categoria_id')
            ->orderBy('nome')
            ->get()
            ->groupBy('categoria.nome');

        // withCount para mostrar quantos produtos cada categoria tem (usado ao bloquear exclusão)
        $categorias = CategoriaCantina::withCount('produtos')->orderBy('nome')->get();

        return view('admin.cantina.index', compact('produtos', 'categorias'));
    }

    // ─── Admin — Categorias ──────────────────────────────────────────────────

    public function storeCategoria(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100|unique:categorias_cantina,nome',
        ]);

        CategoriaCantina::create($request->only('nome'));

        return back()->with('sucesso', 'Categoria criada com sucesso!');
    }

    public function updateCategoria(Request $request, CategoriaCantina $categoria)
    {
        $request->validate([
            'nome' => 'required|string|max:100|unique:categorias_cantina,nome,' . $categoria->id,
        ]);

        $categoria->update($request->only('nome'));

        return back()->with('sucesso', 'Categoria atualizada!');
    }

    // Bloqueia exclusão se ainda houver produtos vinculados (FK é onDelete('restrict'))
    public function destroyCategoria(CategoriaCantina $categoria)
    {
        if ($categoria->produtos()->exists()) {
            return back()->with('erro', 'Não é possível excluir: existem produtos cadastrados nessa categoria.');
        }

        $categoria->delete();

        return back()->with('sucesso', 'Categoria removida.');
    }

    // Formulário de criação de produto (página separada — não modal)
    public function createProduto()
    {
        $categorias = CategoriaCantina::orderBy('nome')->get();
        return view('admin.cantina.produto-form', compact('categorias'));
    }

    public function storeProduto(Request $request)
    {
        $request->validate([
            'categoria_id'       => 'required|exists:categorias_cantina,id',
            'nome'               => 'required|string|max:200',
            'descricao'          => 'nullable|string|max:300',
            'preco'              => 'required|numeric|min:0',
            'quantidade_estoque' => 'required|integer|min:0',
            'foto'               => 'nullable|image|max:2048',
        ]);

        $data = $request->only('categoria_id', 'nome', 'descricao', 'preco', 'quantidade_estoque');
        $data['ativo'] = 1;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('cantina', 'public');
        }

        ProdutoCantina::create($data);

        return redirect()->route('admin.cantina.index')
                         ->with('sucesso', 'Produto cadastrado com sucesso!');
    }

    // Formulário de edição de produto (página separada — não modal)
    public function editProduto(ProdutoCantina $produto)
    {
        $categorias = CategoriaCantina::orderBy('nome')->get();
        return view('admin.cantina.produto-form', compact('produto', 'categorias'));
    }

    public function updateProduto(Request $request, ProdutoCantina $produto)
    {
        $request->validate([
            'categoria_id'       => 'required|exists:categorias_cantina,id',
            'nome'               => 'required|string|max:200',
            'descricao'          => 'nullable|string|max:300',
            'preco'              => 'required|numeric|min:0',
            'quantidade_estoque' => 'required|integer|min:0',
            'foto'               => 'nullable|image|max:2048',
        ]);

        $data = $request->only('categoria_id', 'nome', 'descricao', 'preco', 'quantidade_estoque');

        if ($request->hasFile('foto')) {
            if ($produto->foto) Storage::disk('public')->delete($produto->foto);
            $data['foto'] = $request->file('foto')->store('cantina', 'public');
        }

        $produto->update($data);

        return redirect()->route('admin.cantina.index')
                         ->with('sucesso', 'Produto atualizado!');
    }

    // Soft delete: marca ativo = 0 em vez de deletar do banco
    public function destroyProduto(ProdutoCantina $produto)
    {
        if ($produto->foto) Storage::disk('public')->delete($produto->foto);
        $produto->update(['ativo' => 0]);

        return redirect()->route('admin.cantina.index')
                         ->with('sucesso', 'Produto removido.');
    }

    // Lista todos os pedidos (admin)
    public function pedidos()
    {
        $pedidos = PedidoCantina::with(['usuario', 'itens.produto'])
            ->orderByDesc('created_at')
            ->get();

        return view('cantina.pedidos', compact('pedidos'));
    }

    // Admin deleta pedido permanentemente
    public function destroy(PedidoCantina $pedido)
    {
        // Devolve estoque dos itens antes de deletar
        foreach ($pedido->itens as $item) {
            $item->produto->increment('quantidade_estoque', $item->quantidade);
        }

        $pedido->delete();

        return redirect()->back()->with('sucesso', 'Pedido removido.');
    }

    // ─── Aluno / Professor ───────────────────────────────────────────────────

    // Cardápio: só produtos ativos
    public function index()
    {
        $produtos = ProdutoCantina::with('categoria')
            ->where('ativo', 1)
            ->orderBy('categoria_id')
            ->orderBy('nome')
            ->get()
            ->groupBy('categoria.nome');

        $categorias = CategoriaCantina::orderBy('nome')->get();
        $isAdmin    = false;

        return view('cantina.index', compact('produtos', 'isAdmin', 'categorias'));
    }

    public function fazerPedido(Request $request)
    {
        $request->validate([
            'itens'              => 'required|array|min:1',
            'itens.*.produto_id' => 'required|exists:produtos_cantina,id',
            'itens.*.quantidade' => 'required|integer|min:1',
            'data_retirada'      => 'required|date|after_or_equal:today',
        ]);

        // Verifica estoque de todos antes de gravar qualquer coisa
        foreach ($request->itens as $item) {
            $produto = ProdutoCantina::findOrFail($item['produto_id']);
            if ($produto->quantidade_estoque < $item['quantidade']) {
                return back()->with('erro', "Estoque insuficiente para \"{$produto->nome}\".");
            }
        }

        $pedido = DB::transaction(function () use ($request) {
            $pedido = PedidoCantina::create([
                'user_id'        => Auth::id(),
                'numero_pedido'  => PedidoCantina::proximoNumero(),
                'senha_retirada' => PedidoCantina::gerarSenha(),
                'data_retirada'  => $request->data_retirada,
                'status'         => 'pendente',
            ]);

            foreach ($request->itens as $item) {
                $produto = ProdutoCantina::findOrFail($item['produto_id']);

                ItensPedidoCantina::create([
                    'pedido_id'      => $pedido->id,
                    'produto_id'     => $produto->id,
                    'quantidade'     => $item['quantidade'],
                    'preco_unitario' => $produto->preco,
                ]);

                $produto->decrement('quantidade_estoque', $item['quantidade']);
            }

            return $pedido;
        });

        // Redireciona para meus pedidos; a view exibe modal com número + senha via session
        return redirect()->route('cantina.meus-pedidos')
                         ->with('pedidoConfirmado', $pedido->load('itens.produto'));
    }

    public function meusPedidos()
    {
        $pedidos = PedidoCantina::with('itens.produto')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        // Recupera pedido recém-confirmado da session para exibir modal
        $pedidoConfirmado = session('pedidoConfirmado');

        return view('cantina.meus-pedidos', compact('pedidos', 'pedidoConfirmado'));
    }

    // Usuário cancela o próprio pedido; admin cancela qualquer um
    public function cancelar(PedidoCantina $pedido)
    {
        if (!Auth::user()->isAdmin() && $pedido->user_id !== Auth::id()) {
            abort(403, 'Ação não autorizada.');
        }

        // Devolve estoque
        foreach ($pedido->itens as $item) {
            $item->produto->increment('quantidade_estoque', $item->quantidade);
        }

        $pedido->update(['status' => 'cancelado']);

        return back()->with('sucesso', 'Pedido cancelado.');
    }

    // Gerente marca como entregue (também usado pelo admin)
    public function entregar(PedidoCantina $pedido)
    {
        $pedido->update(['status' => 'entregue']);
        return back()->with('sucesso', 'Pedido marcado como entregue!');
    }

    // ─── Helper estático ─────────────────────────────────────────────────────

    public static function nivelEstoque(int $quantidade): string
    {
        if ($quantidade <= 0) return 'empty';
        if ($quantidade <= self::ESTOQUE_LIMITE_BAIXO) return 'half';
        return 'full';
    }
}