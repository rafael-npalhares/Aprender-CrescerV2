<?php

namespace App\Http\Controllers\Cantina;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CantinaController extends Controller
{
    /**
     * Cardápio base — substitua por CardapioItem::all() quando tiver a migration.
     */
    private function cardapioBase(): array
    {
        return [
            'seg' => [
                ['id'=>1,'nome'=>'X-Burguer Artesanal','descricao'=>'Hambúrguer 160g, queijo cheddar, alface e tomate no pão brioche.','preco'=>14.90,'foto'=>'cantina/hamburguer.jpg','estoque'=>'full'],
                ['id'=>2,'nome'=>'Suco Natural','descricao'=>'Laranja, limão ou maracujá — 300 ml.','preco'=>5.00,'foto'=>'cantina/suco.jpg','estoque'=>'half'],
            ],
            'ter' => [
                ['id'=>3,'nome'=>'Prato Feito','descricao'=>'Arroz, feijão, frango grelhado e salada.','preco'=>16.50,'foto'=>'cantina/prato_feito.jpg','estoque'=>'full'],
            ],
            'qua' => [
                ['id'=>4,'nome'=>'Marmita Fit','descricao'=>'Frango, batata-doce e brócolis no vapor.','preco'=>18.00,'foto'=>'cantina/marmita.jpg','estoque'=>'half'],
            ],
            'qui' => [
                ['id'=>5,'nome'=>'Pizza Fatia','descricao'=>'Fatia de pizza grande — sabores: margherita ou frango.','preco'=>9.90,'foto'=>'cantina/pizza.jpg','estoque'=>'empty'],
            ],
            'sex' => [
                ['id'=>6,'nome'=>'Pastel','descricao'=>'Pastel de forno: queijo, frango ou carne.','preco'=>7.50,'foto'=>'cantina/pastel.jpg','estoque'=>'full'],
                ['id'=>7,'nome'=>'Café + Bolo','descricao'=>'Café coado e fatia de bolo de cenoura com chocolate.','preco'=>6.00,'foto'=>'cantina/cafe_bolo.jpg','estoque'=>'full'],
            ],
        ];
    }

    // ──────────────────────────────────────────
    //  GET /admin/cantina  |  /professor/cantina  |  /aluno/cantina
    // ──────────────────────────────────────────
    public function index()
    {
        $cardapio = $this->cardapioBase();
        return view('cantina.index', compact('cardapio'));
    }

    // ──────────────────────────────────────────
    //  GET /admin/cantina/produtos/criar
    // ──────────────────────────────────────────
    public function createProduto()
    {
        return view('cantina.produto-form');
    }

    // ──────────────────────────────────────────
    //  POST /admin/cantina/produtos
    // ──────────────────────────────────────────
    public function storeProduto(Request $request)
    {
        $request->validate([
            'nome'      => 'required|string|max:120',
            'descricao' => 'nullable|string|max:300',
            'preco'     => 'required|numeric|min:0',
            'estoque'   => 'required|in:full,half,empty',
            'foto'      => 'nullable|image|max:2048',
        ]);

        // TODO: CardapioItem::create([...]) quando tiver o model

        return redirect()->route('admin.cantina.index')
                         ->with('success', 'Produto criado com sucesso!');
    }

    // ──────────────────────────────────────────
    //  GET /admin/cantina/produtos/{produto}/editar
    // ──────────────────────────────────────────
    public function editProduto(int $produto)
    {
        // TODO: $item = CardapioItem::findOrFail($produto);
        return view('cantina.produto-form' /*, compact('item') */);
    }

    // ──────────────────────────────────────────
    //  PATCH /admin/cantina/produtos/{produto}
    //  — chamado pelo modal de edição do blade
    // ──────────────────────────────────────────
    public function updateProduto(Request $request, int $produto)
    {
        $request->validate([
            'nome'      => 'required|string|max:120',
            'descricao' => 'nullable|string|max:300',
            'preco'     => 'required|numeric|min:0',
            'estoque'   => 'required|in:full,half,empty',
            'foto'      => 'nullable|image|max:2048',
        ]);

        // TODO:
        // $item = CardapioItem::findOrFail($produto);
        // $item->update($request->only('nome','descricao','preco','estoque'));
        // if ($request->hasFile('foto')) {
        //     Storage::delete('public/' . $item->foto);
        //     $item->foto = $request->file('foto')->store('cantina', 'public');
        //     $item->save();
        // }

        return redirect()->route('admin.cantina.index')
                         ->with('success', 'Item atualizado com sucesso!');
    }

    // ──────────────────────────────────────────
    //  DELETE /admin/cantina/produtos/{produto}
    // ──────────────────────────────────────────
    public function destroyProduto(int $produto)
    {
        // TODO: CardapioItem::findOrFail($produto)->delete();

        return redirect()->route('admin.cantina.index')
                         ->with('success', 'Produto removido.');
    }

    // ──────────────────────────────────────────
    //  GET /admin/cantina/pedidos
    // ──────────────────────────────────────────
    public function pedidos()
    {
        // TODO: $pedidos = Pedido::with('user')->latest()->get();
        return view('cantina.pedidos' /*, compact('pedidos') */);
    }

    // ──────────────────────────────────────────
    //  POST /professor/cantina/pedidos  |  /aluno/cantina/pedidos
    // ──────────────────────────────────────────
    public function fazerPedido(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|integer',
            'quantidade' => 'required|integer|min:1',
        ]);

        // TODO: Pedido::create([...]);

        return redirect()->back()->with('success', 'Pedido realizado!');
    }

    // ──────────────────────────────────────────
    //  GET /professor/cantina/meus-pedidos  |  /aluno/cantina/meus-pedidos
    // ──────────────────────────────────────────
    public function meusPedidos()
    {
        // TODO: $pedidos = Pedido::where('user_id', auth()->id())->latest()->get();
        return view('cantina.meus-pedidos' /*, compact('pedidos') */);
    }

    // ──────────────────────────────────────────
    //  PATCH /cantina/pedidos/{pedido}/entregar  (admin)
    // ──────────────────────────────────────────
    public function entregar(int $pedido)
    {
        // TODO: Pedido::findOrFail($pedido)->update(['status'=>'entregue']);
        return redirect()->back()->with('success', 'Pedido marcado como entregue.');
    }

    // ──────────────────────────────────────────
    //  PATCH /cantina/pedidos/{pedido}/cancelar  (admin | professor | aluno)
    // ──────────────────────────────────────────
    public function cancelar(int $pedido)
    {
        // TODO: Pedido::findOrFail($pedido)->update(['status'=>'cancelado']);
        return redirect()->back()->with('success', 'Pedido cancelado.');
    }
}