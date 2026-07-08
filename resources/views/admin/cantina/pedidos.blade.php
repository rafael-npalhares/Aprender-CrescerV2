{{-- resources/views/admin/cantina/pedidos.blade.php --}}
@extends('layouts.admin')
@section('titulo', 'Pedidos da Cantina')

@push('styles')
<style>
    .ped-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;
    }
    .ped-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0; }
    .ped-header p  { font-size: .85rem; color: var(--text-secondary); margin: .2rem 0 0; }

    .ped-card {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 14px; padding: 1.1rem 1.3rem; margin-bottom: 1rem;
    }
    .ped-top {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: .75rem; margin-bottom: .75rem;
    }
    .ped-numero { font-weight: 700; font-size: .95rem; color: var(--text-main); }
    .ped-senha { font-size: .78rem; color: var(--text-secondary); }

    .ped-status {
        font-size: .72rem; font-weight: 700; padding: .25rem .7rem; border-radius: 20px;
        text-transform: uppercase; letter-spacing: .04em;
    }
    .status-pendente { background: var(--badge-yellow-bg); color: var(--badge-yellow); }
    .status-entregue { background: var(--badge-green-bg); color: var(--badge-green); }
    .status-cancelado { background: var(--badge-red-bg); color: var(--badge-red); }

    .ped-meta {
        display: flex; gap: 1.25rem; flex-wrap: wrap;
        font-size: .8rem; color: var(--text-secondary); margin-bottom: .85rem;
    }

    .ped-itens { border-top: 1px solid var(--border-color); padding-top: .7rem; margin-bottom: .85rem; }
    .ped-item-row {
        display: flex; justify-content: space-between;
        font-size: .85rem; color: var(--text-main); padding: .25rem 0;
    }
    .ped-item-row span:last-child { color: var(--text-secondary); }
    .ped-total {
        display: flex; justify-content: space-between; font-weight: 700;
        font-size: .88rem; color: var(--text-main); border-top: 1px solid var(--border-color);
        padding-top: .5rem; margin-top: .3rem;
    }

    .ped-actions { display: flex; gap: .5rem; flex-wrap: wrap; }

    .empty-state {
        text-align: center; padding: 3.5rem 1rem; color: var(--text-secondary);
        background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 14px;
    }
    .empty-state i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: var(--border-color); }
</style>
@endpush

@section('conteudo')

<div class="ped-header">
    <div>
        <h1><i class="bi bi-receipt" style="color:var(--blue-primary);"></i> Pedidos da Cantina</h1>
        <p>{{ $pedidos->count() }} pedido(s) no sistema</p>
    </div>
    <a href="{{ route('admin.cantina.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Voltar para produtos
    </a>
</div>

@forelse($pedidos as $pedido)
@php
    $statusClasse = match($pedido->status) {
        'entregue'  => 'status-entregue',
        'cancelado' => 'status-cancelado',
        default     => 'status-pendente',
    };
    $statusLabel = match($pedido->status) {
        'entregue'  => 'Entregue',
        'cancelado' => 'Cancelado',
        default     => 'Pendente',
    };
    $total = $pedido->itens->sum(fn($i) => $i->quantidade * $i->preco_unitario);
@endphp

<div class="ped-card">
    <div class="ped-top">
        <div>
            <span class="ped-numero">Pedido #{{ $pedido->numero_pedido }}</span>
            <span class="ped-senha"> · senha {{ $pedido->senha_retirada }}</span>
        </div>
        <span class="ped-status {{ $statusClasse }}">{{ $statusLabel }}</span>
    </div>

    <div class="ped-meta">
        <span><i class="bi bi-person"></i> {{ $pedido->usuario->name ?? '—' }}</span>
        <span><i class="bi bi-calendar-check"></i> Retirada: {{ \Carbon\Carbon::parse($pedido->data_retirada)->format('d/m/Y') }}</span>
        <span><i class="bi bi-clock-history"></i> Feito em {{ $pedido->created_at->format('d/m/Y H:i') }}</span>
    </div>

    <div class="ped-itens">
        @foreach($pedido->itens as $item)
        <div class="ped-item-row">
            <span>{{ $item->quantidade }}× {{ $item->produto->nome ?? 'Produto removido' }}</span>
            <span>R$ {{ number_format($item->quantidade * $item->preco_unitario, 2, ',', '.') }}</span>
        </div>
        @endforeach
        <div class="ped-total">
            <span>Total</span>
            <span>R$ {{ number_format($total, 2, ',', '.') }}</span>
        </div>
    </div>

    <div class="ped-actions">
        @if($pedido->status === 'pendente')
            <form action="{{ route('admin.cantina.pedidos.cancelar', $pedido) }}" method="POST"
                  onsubmit="return confirm('Cancelar este pedido? O estoque será devolvido.')">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-outline-warning btn-sm">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
            </form>
        @endif

        <form action="{{ route('admin.cantina.pedidos.destroy', $pedido) }}" method="POST"
              onsubmit="return confirm('Excluir este pedido permanentemente? Esta ação não pode ser desfeita.')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-trash"></i> Excluir
            </button>
        </form>
    </div>
</div>

@empty
<div class="empty-state">
    <i class="bi bi-receipt"></i>
    <p>Nenhum pedido registrado ainda.</p>
</div>
@endforelse

@endsection