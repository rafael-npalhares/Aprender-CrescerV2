<?php

namespace App\Http\Controllers\Cantina;

use App\Http\Controllers\Controller;
use App\Models\ProdutoCantina;
use App\Models\PedidoCantina;
use Illuminate\Http\Request;

class CantinaController extends Controller
{
    // Catálogo de produtos disponíveis
    public function index()
    {
        $produtos = ProdutoCantina::where('ativo', true)
                                  ->where('quantidade_estoque', '>', 0)
                                  ->orderBy('nome')->get();

        return view('cantina.index', compact('produtos'));
    }

    // Fazer pedido (RN-07: só aceita produto com estoque > 0)
    public function fazerPedido(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos_cantina,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        $produto = ProdutoCantina::findOrFail($request->produto_id);

        if ($produto->quantidade_estoque < $request->quantidade) {
            return back()->with('erro', 'Estoque insuficiente.');
        }

        PedidoCantina::create([
            'user_id'    => auth()->id(),
            'produto_id' => $produto->id,
            'quantidade' => $request->quantidade,
            'status'     => 'pendente',
        ]);

        $produto->decrement('quantidade_estoque', $request->quantidade);

        return back()->with('sucesso', 'Pedido realizado!');
    }

    // Meus pedidos
    public function meusPedidos()
    {
        $pedidos = PedidoCantina::where('user_id', auth()->id())
                                ->with('produto')->latest()->get();

        return view('cantina.pedidos', compact('pedidos'));
    }

    // Admin — marcar pedido como entregue
    public function entregar(PedidoCantina $pedido)
    {
        $pedido->update(['status' => 'entregue']);

        return back()->with('sucesso', 'Pedido marcado como entregue!');
    }

    // Cancelar pedido
    public function cancelar(PedidoCantina $pedido)
    {
        $pedido->update(['status' => 'cancelado']);
        $pedido->produto->increment('quantidade_estoque', $pedido->quantidade);

        return back()->with('sucesso', 'Pedido cancelado.');
    }

    // Admin — formulário de cadastro de produto
    public function createProduto()
    {
        return view('admin.cantina.create');
    }

    // Admin — salva novo produto no catálogo
    public function storeProduto(Request $request)
    {
        $request->validate([
            'nome'               => 'required|string|max:200',
            'preco'              => 'required|numeric|min:0',
            'quantidade_estoque' => 'required|integer|min:0',
        ]);

        ProdutoCantina::create($request->all());

        return redirect()->route('admin.cantina.index')
                         ->with('sucesso', 'Produto cadastrado!');
    }
}