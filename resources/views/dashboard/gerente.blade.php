{{-- resources/views/dashboard/gerente.blade.php --}}
@extends('layouts.admin')
@section('titulo', 'Dashboard')

@push('styles')
<style>
    .stat-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
    .stat-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 14px; padding: 1.25rem; }
    .stat-card .valor { font-size: 1.8rem; font-weight: 800; color: var(--text-main); }
    .stat-card .label { font-size: .8rem; color: var(--text-secondary); margin-top: .2rem; }

    .senha-chip {
        display: inline-flex; align-items: center; gap: .4rem;
        background: var(--badge-blue-bg); color: var(--badge-blue);
        border-radius: 8px; padding: .3rem .75rem; font-size: .8rem; font-weight: 700; letter-spacing: .05em;
    }
</style>
@endpush

@section('conteudo')

<div class="page-header">
    <div>
        <h1>Painel da Cantina</h1>
        <p>Confira as senhas de retirada e gerencie os pedidos pendentes.</p>
    </div>
    <a href="{{ route('gerente.pedidos.index') }}" class="btn btn-primary">Ver todos os pedidos</a>
</div>

<div class="stat-cards">
    <div class="stat-card">
        <div class="valor">{{ $totalPendentes }}</div>
        <div class="label">Pedidos pendentes</div>
    </div>
    <div class="stat-card">
        <div class="valor">{{ $totalEntreguesHoje }}</div>
        <div class="label">Entregues hoje</div>
    </div>
    <div class="stat-card">
        <div class="valor">{{ $totalCanceladosHoje }}</div>
        <div class="label">Cancelados hoje</div>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Cliente</th>
                    <th>Senha</th>
                    <th>Retirada</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendentes as $pedido)
                <tr>
                    <td class="fw-600">{{ $pedido->numero_formatado }}</td>
                    <td>{{ $pedido->usuario->name }}</td>
                    <td><span class="senha-chip"><i class="bi bi-key-fill"></i> {{ $pedido->senha_retirada }}</span></td>
                    <td>{{ $pedido->data_retirada->format('d/m/Y') }}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <form action="{{ route('gerente.pedidos.entregar', $pedido) }}" method="POST"
                                  onsubmit="return confirm('Confirmar entrega do pedido {{ $pedido->numero_formatado }}?')">
                                @csrf @method('PATCH')
                                <button class="btn btn-primary btn-sm">Entregar</button>
                            </form>
                            <form action="{{ route('gerente.pedidos.cancelar', $pedido) }}" method="POST"
                                  onsubmit="return confirm('Cancelar o pedido {{ $pedido->numero_formatado }}?')">
                                @csrf @method('PATCH')
                                <button class="btn btn-danger btn-sm">Cancelar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon">🎉</div>
                            <p>Nenhum pedido pendente no momento.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection