<?php

namespace App\Http\Controllers\Cantina;

use App\Http\Controllers\Controller;
use App\Models\PedidoCantina;

class GerenteController extends Controller
{
    public function index()
    {
        $pendentes = PedidoCantina::with(['usuario', 'itens.produto'])
            ->pendentes()
            ->orderBy('created_at')
            ->get();

        $totalPendentes      = $pendentes->count();
        $totalEntreguesHoje  = PedidoCantina::entregues()->whereDate('updated_at', today())->count();
        $totalCanceladosHoje = PedidoCantina::cancelados()->whereDate('updated_at', today())->count();

        return view('dashboard.gerente', [
            'pendentes'           => $pendentes->take(5),
            'totalPendentes'      => $totalPendentes,
            'totalEntreguesHoje'  => $totalEntreguesHoje,
            'totalCanceladosHoje' => $totalCanceladosHoje,
        ]);
    }

    public function pedidos()
    {
        $pendentes = PedidoCantina::with(['usuario', 'itens.produto'])
            ->pendentes()
            ->orderBy('created_at')
            ->get();

        $historico = PedidoCantina::with(['usuario', 'itens.produto'])
            ->whereIn('status', ['entregue', 'cancelado'])
            ->orderByDesc('updated_at')
            ->limit(50)
            ->get();

        return view('gerente.pedidos', compact('pendentes', 'historico'));
    }

    public function show(PedidoCantina $pedido)
    {
        $pedido->load(['usuario', 'itens.produto']);

        return view('gerente.pedido-detalhe', compact('pedido'));
    }

    public function entregar(PedidoCantina $pedido)
    {
        if ($pedido->status !== 'pendente') {
            return back()->with('erro', 'Este pedido já foi finalizado.');
        }

        $pedido->marcarEntregue();

        return back()->with('sucesso', "Pedido {$pedido->numero_formatado} marcado como entregue!");
    }

    public function cancelar(PedidoCantina $pedido)
    {
        if ($pedido->status !== 'pendente') {
            return back()->with('erro', 'Este pedido já foi finalizado.');
        }

        $pedido->cancelarPedido();

        return back()->with('sucesso', "Pedido {$pedido->numero_formatado} cancelado.");
    }
}