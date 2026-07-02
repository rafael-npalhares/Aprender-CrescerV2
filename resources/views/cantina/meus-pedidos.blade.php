{{-- resources/views/cantina/meus-pedidos.blade.php --}}
@extends('layouts.admin')
@section('titulo', 'Meus Pedidos')

@push('styles')
<style>
    .ped-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;
    }
    .ped-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0; }
    .ped-header p  { font-size: .85rem; color: var(--text-secondary); margin: .2rem 0 0; }

    .pedido-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 14px; overflow: hidden; margin-bottom: 1rem; }
    .pedido-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1rem 1.25rem; flex-wrap: wrap; gap: .5rem; cursor: pointer;
    }
    .pedido-numero { font-weight: 700; font-size: 1.05rem; color: var(--text-main); }
    .pedido-meta { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
    .pedido-meta span { font-size: .8rem; color: var(--text-secondary); }
    .pedido-chevron { color: var(--text-secondary); transition: transform .2s; }
    .pedido-chevron.open { transform: rotate(180deg); }

    .badge-status { font-size: .7rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; padding: .3rem .7rem; border-radius: 20px; }
    .badge-pendente  { background: var(--badge-yellow-bg); color: var(--badge-yellow); }
    .badge-entregue  { background: var(--badge-green-bg);  color: var(--badge-green); }
    .badge-cancelado { background: var(--badge-red-bg);    color: var(--badge-red); }

    .pedido-body { padding: 0 1.25rem 1.25rem; border-top: 1px solid var(--border-color); }
    .item-row { display: flex; justify-content: space-between; padding: .5rem 0; border-bottom: 1px solid var(--border-color); font-size: .85rem; }
    .item-row:last-child { border-bottom: none; }

    .pedido-footer-info { display: flex; justify-content: space-between; flex-wrap: wrap; gap: .75rem; padding-top: .8rem; }
    .pedido-total { font-weight: 700; color: var(--text-main); }
    .senha-chip {
        display: inline-flex; align-items: center; gap: .4rem;
        background: var(--badge-blue-bg); color: var(--badge-blue);
        border-radius: 8px; padding: .3rem .75rem; font-size: .8rem; font-weight: 700; letter-spacing: .05em;
    }

    .confirm-numero { text-align: center; margin-bottom: 1.5rem; }
    .confirm-numero .label { font-size: .7rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--text-secondary); }
    .confirm-numero .valor { font-size: 2.3rem; font-weight: 800; color: var(--text-main); }
    .confirm-senha-box { background: var(--badge-blue-bg); border: 1px solid rgba(88,166,255,.3); border-radius: 12px; padding: 1rem 1.25rem; text-align: center; margin-bottom: 1.25rem; }
    .confirm-senha-box .lbl { font-size: .7rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--text-secondary); margin-bottom: .4rem; }
    .confirm-senha-box .senha { font-size: 1.9rem; font-weight: 800; letter-spacing: .3em; color: var(--badge-blue); }
</style>
@endpush

@section('conteudo')

<div class="ped-header">
    <div>
        <h1><i class="bi bi-receipt" style="color:var(--blue-primary);"></i> Meus Pedidos</h1>
        <p>Acompanhe seus pedidos e senhas de retirada.</p>
    </div>
    <a href="{{ route('cantina.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Novo pedido</a>
</div>

@forelse($pedidos as $pedido)
@php
    $total = $pedido->itens->sum(fn($i) => $i->quantidade * $i->preco_unitario);
    $statusClass = match($pedido->status) { 'entregue' => 'badge-entregue', 'cancelado' => 'badge-cancelado', default => 'badge-pendente' };
    $statusLabel = match($pedido->status) { 'entregue' => 'Entregue', 'cancelado' => 'Cancelado', default => 'Pendente' };
@endphp

<div class="pedido-card">
    <div class="pedido-header" onclick="togglePedido({{ $pedido->id }})">
        <div class="d-flex align-items-center gap-3">
            <span class="pedido-numero">{{ $pedido->numero_formatado }}</span>
            <span class="badge-status {{ $statusClass }}">{{ $statusLabel }}</span>
        </div>
        <div class="pedido-meta">
            <span><i class="bi bi-calendar3"></i> Retirada: {{ $pedido->data_retirada->format('d/m/Y') }}</span>
            <span><i class="bi bi-clock"></i> {{ $pedido->created_at->format('d/m/Y H:i') }}</span>
            <i class="bi bi-chevron-down pedido-chevron" id="chevron-{{ $pedido->id }}"></i>
        </div>
    </div>

    <div class="pedido-body" id="corpo-{{ $pedido->id }}" style="display:none;">
        @foreach($pedido->itens as $item)
        <div class="item-row">
            <span>{{ $item->produto->nome }} <span class="text-secondary">× {{ $item->quantidade }}</span></span>
            <span>R$ {{ number_format($item->quantidade * $item->preco_unitario, 2, ',', '.') }}</span>
        </div>
        @endforeach

        <div class="pedido-footer-info">
            <span class="pedido-total">Total: R$ {{ number_format($total, 2, ',', '.') }}</span>
            @if($pedido->status === 'pendente')
                <span class="senha-chip"><i class="bi bi-key-fill"></i> Senha: {{ $pedido->senha_retirada }}</span>
            @endif
        </div>

        @if($pedido->status === 'pendente')
        <form action="{{ route('cantina.pedidos.cancelar', $pedido->id) }}" method="POST"
              onsubmit="return confirm('Cancelar este pedido?')" class="mt-3">
            @csrf @method('PATCH')
            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-x-lg"></i> Cancelar pedido</button>
        </form>
        @endif
    </div>
</div>
@empty
<div class="empty-state">
    <i class="bi bi-cart-x empty-icon"></i>
    <p>Você ainda não fez nenhum pedido.</p>
    <a href="{{ route('cantina.index') }}" class="btn btn-primary btn-sm">Ver cardápio</a>
</div>
@endforelse

{{-- MODAL: confirmação recém feita --}}
@if(session('pedidoConfirmado'))
@php $pc = session('pedidoConfirmado'); @endphp
<div class="modal fade" id="modalConfirmacao" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-check-circle-fill" style="color:var(--badge-green);"></i> Pedido confirmado!</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="confirm-numero">
                    <div class="label">Número do pedido</div>
                    <div class="valor">{{ $pc->numero_formatado }}</div>
                </div>
                <div class="confirm-senha-box">
                    <div class="lbl">Senha de retirada</div>
                    <div class="senha">{{ $pc->senha_retirada }}</div>
                </div>
                @foreach($pc->itens as $item)
                <div class="item-row">
                    <span>{{ $item->quantidade }}× {{ $item->produto->nome }}</span>
                    <span>R$ {{ number_format($item->quantidade * $item->preco_unitario, 2, ',', '.') }}</span>
                </div>
                @endforeach
                <div class="item-row" style="font-weight:700;border-top:1px solid var(--border-color);margin-top:.5rem;">
                    <span>Total</span>
                    <span>R$ {{ number_format($pc->itens->sum(fn($i) => $i->quantidade * $i->preco_unitario), 2, ',', '.') }}</span>
                </div>
                <p class="mt-3 mb-0" style="font-size:.8rem;color:var(--text-secondary);">
                    <i class="bi bi-calendar3"></i> Retirada agendada para
                    <strong style="color:var(--text-main);">{{ \Carbon\Carbon::parse($pc->data_retirada)->format('d/m/Y') }}</strong>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
function togglePedido(id) {
    const corpo = document.getElementById('corpo-' + id);
    const chevron = document.getElementById('chevron-' + id);
    const aberto = corpo.style.display !== 'none';
    corpo.style.display = aberto ? 'none' : '';
    chevron.classList.toggle('open', !aberto);
}

@if(session('pedidoConfirmado'))
document.addEventListener('DOMContentLoaded', function () {
    new bootstrap.Modal(document.getElementById('modalConfirmacao')).show();
});
@endif
</script>
@endpush