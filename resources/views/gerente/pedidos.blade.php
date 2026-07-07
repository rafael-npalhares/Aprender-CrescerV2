{{-- resources/views/gerente/pedidos.blade.php --}}
@extends('layouts.admin')
@section('titulo', 'Pedidos da Cantina')

@push('styles')
<style>
    .ped-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
    .ped-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0; }
    .ped-header p  { font-size: .85rem; color: var(--text-secondary); margin: .2rem 0 0; }

    .tabs { display: flex; gap: .5rem; margin-bottom: 1.25rem; border-bottom: 1px solid var(--border-color); }
    .tab-btn { background: none; border: none; padding: .6rem 1rem; color: var(--text-secondary); font-weight: 600; font-size: .9rem; cursor: pointer; border-bottom: 2px solid transparent; }
    .tab-btn.active { color: var(--text-main); border-bottom-color: var(--blue-primary); }

    .pedido-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 14px; overflow: hidden; margin-bottom: 1rem; }
    .pedido-header { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem; flex-wrap: wrap; gap: .5rem; cursor: pointer; }
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
</style>
@endpush

@section('conteudo')

<div class="ped-header">
    <div>
        <h1><i class="bi bi-bag-fill" style="color:var(--blue-primary);"></i> Pedidos da Cantina</h1>
        <p>Confira a senha informada pelo cliente antes de confirmar a entrega.</p>
    </div>
</div>

<div class="tabs">
    <button class="tab-btn active" onclick="mostrarAba('pendentes', this)">Pendentes ({{ $pendentes->count() }})</button>
    <button class="tab-btn" onclick="mostrarAba('historico', this)">Histórico ({{ $historico->count() }})</button>
</div>

{{-- ───── PENDENTES ───── --}}
<div id="aba-pendentes">
    @forelse($pendentes as $pedido)
    @php $total = $pedido->itens->sum(fn($i) => $i->quantidade * $i->preco_unitario); @endphp
    <div class="pedido-card">
        <div class="pedido-header" onclick="togglePedido({{ $pedido->id }})">
            <div class="d-flex align-items-center gap-3">
                <span class="pedido-numero">{{ $pedido->numero_formatado }}</span>
                <span class="badge-status badge-pendente">Pendente</span>
                <span>{{ $pedido->usuario->name }}</span>
            </div>
            <div class="pedido-meta">
                <span class="senha-chip"><i class="bi bi-key-fill"></i> {{ $pedido->senha_retirada }}</span>
                <span><i class="bi bi-calendar3"></i> Retirada: {{ $pedido->data_retirada->format('d/m/Y') }}</span>
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
                <div style="display:flex; gap:6px;">
                    <form action="{{ route('gerente.pedidos.entregar', $pedido) }}" method="POST"
                          onsubmit="return confirm('Confirmar entrega do pedido {{ $pedido->numero_formatado }}? Verifique se a senha informada pelo cliente é {{ $pedido->senha_retirada }}.')">
                        @csrf @method('PATCH')
                        <button class="btn btn-primary btn-sm"><i class="bi bi-check-lg"></i> Confirmar entrega</button>
                    </form>
                    <form action="{{ route('gerente.pedidos.cancelar', $pedido) }}" method="POST"
                          onsubmit="return confirm('Cancelar este pedido?')">
                        @csrf @method('PATCH')
                        <button class="btn btn-outline-danger btn-sm"><i class="bi bi-x-lg"></i> Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <i class="bi bi-cart-check empty-icon"></i>
        <p>Nenhum pedido pendente no momento.</p>
    </div>
    @endforelse
</div>

{{-- ───── HISTÓRICO ───── --}}
<div id="aba-historico" style="display:none;">
    @forelse($historico as $pedido)
    @php
        $total = $pedido->itens->sum(fn($i) => $i->quantidade * $i->preco_unitario);
        $statusClass = $pedido->status === 'entregue' ? 'badge-entregue' : 'badge-cancelado';
        $statusLabel = $pedido->status === 'entregue' ? 'Entregue' : 'Cancelado';
    @endphp
    <div class="pedido-card">
        <div class="pedido-header" onclick="togglePedido({{ $pedido->id }})">
            <div class="d-flex align-items-center gap-3">
                <span class="pedido-numero">{{ $pedido->numero_formatado }}</span>
                <span class="badge-status {{ $statusClass }}">{{ $statusLabel }}</span>
                <span>{{ $pedido->usuario->name }}</span>
            </div>
            <div class="pedido-meta">
                <span><i class="bi bi-clock-history"></i> {{ $pedido->updated_at->format('d/m/Y H:i') }}</span>
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
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <i class="bi bi-inbox empty-icon"></i>
        <p>Nenhum pedido no histórico ainda.</p>
    </div>
    @endforelse
</div>

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

function mostrarAba(nome, btn) {
    document.getElementById('aba-pendentes').style.display = nome === 'pendentes' ? '' : 'none';
    document.getElementById('aba-historico').style.display = nome === 'historico' ? '' : 'none';
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}
</script>
@endpush