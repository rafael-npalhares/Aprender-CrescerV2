{{-- resources/views/gerente/pedido-detalhe.blade.php --}}
@extends('layouts.admin')
@section('titulo', 'Pedido ' . $pedido->numero_formatado)

@push('styles')
<style>
    .senha-box { background: var(--badge-blue-bg); border: 1px solid rgba(88,166,255,.3); border-radius: 12px; padding: 1rem 1.25rem; text-align: center; margin-bottom: 1.25rem; }
    .senha-box .lbl { font-size: .7rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--text-secondary); margin-bottom: .4rem; }
    .senha-box .senha { font-size: 1.9rem; font-weight: 800; letter-spacing: .3em; color: var(--badge-blue); }
    .item-row { display: flex; justify-content: space-between; padding: .5rem 0; border-bottom: 1px solid var(--border-color); font-size: .9rem; }
    .item-row:last-child { border-bottom: none; }
    .badge-status { font-size: .7rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; padding: .3rem .7rem; border-radius: 20px; }
    .badge-pendente  { background: var(--badge-yellow-bg); color: var(--badge-yellow); }
    .badge-entregue  { background: var(--badge-green-bg);  color: var(--badge-green); }
    .badge-cancelado { background: var(--badge-red-bg);    color: var(--badge-red); }
</style>
@endpush

@section('conteudo')

@php
    $total = $pedido->itens->sum(fn($i) => $i->quantidade * $i->preco_unitario);
    $statusClass = match($pedido->status) { 'entregue' => 'badge-entregue', 'cancelado' => 'badge-cancelado', default => 'badge-pendente' };
    $statusLabel = match($pedido->status) { 'entregue' => 'Entregue', 'cancelado' => 'Cancelado', default => 'Pendente' };
@endphp

<div class="page-header">
    <div>
        <h1>Pedido {{ $pedido->numero_formatado }}</h1>
        <p>{{ $pedido->usuario->name }} &middot; <span class="badge-status {{ $statusClass }}">{{ $statusLabel }}</span></p>
    </div>
    <a href="{{ route('gerente.pedidos.index') }}" class="btn btn-secondary">Voltar</a>
</div>

@if($pedido->status === 'pendente')
<div class="senha-box">
    <div class="lbl">Senha de retirada</div>
    <div class="senha">{{ $pedido->senha_retirada }}</div>
</div>
@endif

<div class="card">
    @foreach($pedido->itens as $item)
    <div class="item-row">
        <span>{{ $item->produto->nome }} <span class="text-secondary">× {{ $item->quantidade }}</span></span>
        <span>R$ {{ number_format($item->quantidade * $item->preco_unitario, 2, ',', '.') }}</span>
    </div>
    @endforeach
    <div class="item-row" style="font-weight:700; border-top:1px solid var(--border-color); margin-top:.5rem;">
        <span>Total</span>
        <span>R$ {{ number_format($total, 2, ',', '.') }}</span>
    </div>
</div>

@if($pedido->status === 'pendente')
<div style="display:flex; gap:8px; margin-top:1.25rem;">
    <form action="{{ route('gerente.pedidos.entregar', $pedido) }}" method="POST"
          onsubmit="return confirmarAcao(this, 'Confirmar entrega do pedido {{ $pedido->numero_formatado }}?', 'Confirmar entrega')">
        @csrf @method('PATCH')
        <button class="btn btn-primary">Confirmar entrega</button>
    </form>
    <form action="{{ route('gerente.pedidos.cancelar', $pedido) }}" method="POST"
          onsubmit="return confirmarAcao(this, 'Tem certeza que deseja cancelar este pedido? O estoque dos produtos será restaurado.', 'Cancelar pedido')">
        @csrf @method('PATCH')
        <button class="btn btn-outline-danger">Cancelar</button>
    </form>
</div>
@endif

@endsection