<?php

namespace App\Http\Controllers\Cantina;

use App\Http\Controllers\Controller;
use App\Models\ProdutoCantina;
use App\Models\PedidoCantina;
use App\Models\ItensPedidoCantina;
use App\Models\CategoriaCantina;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CantinaController extends Controller
{
    private const ESTOQUE_LIMITE_BAIXO = 5;

    // ─── Admin ───────────────────────────────────────────────────────────────

    public function adminIndex()
    {
        $produtos = ProdutoCantina::with('categoria')
            ->orderBy('categoria_id')->orderBy('nome')
            ->get()->groupBy('categoria.nome');

        $categorias = CategoriaCantina::withCount('produtos')->orderBy('nome')->get();

        return view('admin.cantina.index', compact('produtos', 'categorias'));
    }

    public function storeCategoria(Request $request)
    {
        $request->validate(['nome' => 'required|string|max:100|unique:categorias_cantina,nome']);
        CategoriaCantina::create($request->only('nome'));
        return back()->with('sucesso', 'Categoria criada com sucesso!');
    }

    public function updateCategoria(Request $request, CategoriaCantina $categoria)
    {
        $request->validate(['nome' => 'required|string|max:100|unique:categorias_cantina,nome,' . $categoria->id]);
        $categoria->update($request->only('nome'));
        return back()->with('sucesso', 'Categoria atualizada!');
    }

    public function destroyCategoria(CategoriaCantina $categoria)
    {
        if ($categoria->produtos()->exists()) {
            return back()->with('erro', 'Não é possível excluir: existem produtos nessa categoria.');
        }
        $categoria->delete();
        return back()->with('sucesso', 'Categoria removida.');
    }

    public function createProduto()
    {
        $categorias = CategoriaCantina::orderBy('nome')->get();
        return view('cantina.produto-form', compact('categorias'));
    }

    public function storeProduto(Request $request)
    {
        $request->validate([
            'categoria_id'       => 'required|exists:categorias_cantina,id',
            'nome'               => 'required|string|max:200',
            'descricao'          => 'nullable|string|max:300',
            'preco'              => 'required|numeric|min:0',
            'quantidade_estoque' => 'required|integer|min:0',
            'foto'               => 'nullable|image|max:2048', // 2MB, jpg/png/webp etc.
        ]);

        $dados = $request->only('categoria_id', 'nome', 'descricao', 'preco', 'quantidade_estoque');
        $dados['ativo'] = 1;

        if ($request->hasFile('foto')) {
            $dados['foto'] = $this->salvarFoto($request->file('foto'));
        }

        ProdutoCantina::create($dados);

        return redirect()->route('admin.cantina.index')
                         ->with('sucesso', 'Produto cadastrado com sucesso!');
    }

    public function editProduto(ProdutoCantina $produto)
    {
        $categorias = CategoriaCantina::orderBy('nome')->get();
        return view('admin.cantina.produto-form', compact('produto', 'categorias'));
    }

    // Editar permite mudar nome, preco, quantidade_estoque e agora também a foto
    public function updateProduto(Request $request, ProdutoCantina $produto)
    {
        $request->validate([
            'nome'               => 'required|string|max:200',
            'preco'              => 'required|numeric|min:0',
            'quantidade_estoque' => 'required|integer|min:0',
            'foto'               => 'nullable|image|max:2048',
        ]);

        $dados = $request->only('nome', 'preco', 'quantidade_estoque');

        if ($request->hasFile('foto')) {
            // remove a foto antiga do disco, se existir, antes de salvar a nova
            $this->removerFoto($produto->foto);
            $dados['foto'] = $this->salvarFoto($request->file('foto'));
        }

        $produto->update($dados);

        return redirect()->route('admin.cantina.index')
                         ->with('sucesso', 'Produto atualizado!');
    }

    public function destroyProduto(ProdutoCantina $produto)
    {
        $produto->update(['ativo' => 0]);
        return redirect()->route('admin.cantina.index')
                         ->with('sucesso', 'Produto removido.');
    }

    public function ativarProduto(ProdutoCantina $produto)
    {
        $produto->update(['ativo' => 1]);
        return redirect()->route('admin.cantina.index')
                         ->with('sucesso', 'Produto reativado!');
    }

    public function pedidos()
    {
        $pedidos = PedidoCantina::with(['usuario', 'itens.produto'])
            ->orderByDesc('created_at')->get();
        return view('cantina.pedidos', compact('pedidos'));
    }

    public function destroy(PedidoCantina $pedido)
    {
        foreach ($pedido->itens as $item) {
            $item->produto->increment('quantidade_estoque', $item->quantidade);
        }
        $pedido->delete();
        return redirect()->back()->with('sucesso', 'Pedido removido.');
    }

    // ─── Aluno / Professor ───────────────────────────────────────────────────

    public function index()
    {
        $produtos = ProdutoCantina::with('categoria')
            ->where('ativo', 1)
            ->orderBy('categoria_id')->orderBy('nome')
            ->get()->groupBy('categoria.nome');

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

        return redirect()->route('cantina.meus-pedidos')
                         ->with('pedidoConfirmado', $pedido->load('itens.produto'));
    }

    public function meusPedidos()
    {
        $pedidos = PedidoCantina::with('itens.produto')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')->get();

        $pedidoConfirmado = session('pedidoConfirmado');

        return view('cantina.meus-pedidos', compact('pedidos', 'pedidoConfirmado'));
    }

    public function cancelar(PedidoCantina $pedido)
    {
        if (!Auth::user()->isAdmin() && $pedido->user_id !== Auth::id()) {
            abort(403, 'Ação não autorizada.');
        }
        foreach ($pedido->itens as $item) {
            $item->produto->increment('quantidade_estoque', $item->quantidade);
        }
        $pedido->update(['status' => 'cancelado']);
        return back()->with('sucesso', 'Pedido cancelado.');
    }

    public function entregar(PedidoCantina $pedido)
    {
        $pedido->update(['status' => 'entregue']);
        return back()->with('sucesso', 'Pedido marcado como entregue!');
    }

    public static function nivelEstoque(int $quantidade): string
    {
        if ($quantidade <= 0) return 'empty';
        if ($quantidade <= self::ESTOQUE_LIMITE_BAIXO) return 'half';
        return 'full';
    }

    // ─── Helpers privados de upload ──────────────────────────────────────────

    /**
     * Salva o arquivo enviado em public/img/cantina/ com um nome único
     * e retorna o caminho relativo (ex: "img/cantina/abc123.jpg")
     * no mesmo formato já usado pelo Model (ProdutoCantina::getFotoUrlAttribute).
     */
    private function salvarFoto(UploadedFile $arquivo): string
    {
        $destino = public_path('img/cantina');

        if (!File::isDirectory($destino)) {
            File::makeDirectory($destino, 0755, true);
        }

        $nomeArquivo = Str::uuid() . '.' . $arquivo->getClientOriginalExtension();
        $arquivo->move($destino, $nomeArquivo);

        return 'img/cantina/' . $nomeArquivo;
    }

    /**
     * Remove do disco uma foto antiga do produto (se existir e não for a padrão).
     */
    private function removerFoto(?string $caminhoRelativo): void
    {
        if (!$caminhoRelativo) {
            return;
        }

        $caminhoAbsoluto = public_path($caminhoRelativo);

        if (File::exists($caminhoAbsoluto)) {
            File::delete($caminhoAbsoluto);
        }
    }
}