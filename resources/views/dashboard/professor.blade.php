{{-- resources/views/dashboard/professor.blade.php --}}
@extends('layouts.app')
@section('titulo', 'Dashboard — Professor')

@section('conteudo')
@include('componentes.alerta')

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background:#2d6ef71a;">
                    <i class="bi bi-megaphone-fill" style="color:#2d6ef7;font-size:1.3rem;"></i>
                </div>
                <div>
                    <div class="fw-bold fs-4" style="color:#1a2238;">{{ $avisos->count() }}</div>
                    <div style="font-size:.8rem;color:#8899bb;">Avisos Ativos</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background:#22c55e1a;">
                    <i class="bi bi-calendar-check-fill" style="color:#22c55e;font-size:1.3rem;"></i>
                </div>
                <div>
                    <div class="fw-bold fs-4" style="color:#1a2238;">{{ $minhasReservas->count() }}</div>
                    <div style="font-size:.8rem;color:#8899bb;">Minhas Reservas</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white py-3" style="border-bottom:1px solid #e8eaf0;">
                <span class="fw-semibold" style="color:#1a2238;">Avisos Recentes</span>
            </div>
            <div class="card-body">
                @forelse($avisos as $aviso)
                    @include('componentes.card-aviso', ['aviso' => $aviso])
                @empty
                    <p class="text-muted text-center mt-2">Nenhum aviso no momento.</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white py-3" style="border-bottom:1px solid #e8eaf0;">
                <span class="fw-semibold" style="color:#1a2238;">Minhas Reservas</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Recurso</th><th>Data</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($minhasReservas as $r)
                            <tr>
                                <td>{{ $r->recurso ?? '—' }}</td>
                                <td>{{ $r->data_reserva ?? '—' }}</td>
                                <td>
                                    @if($r->status === 'aprovada')
                                        <span class="badge" style="background:#22c55e1a;color:#22c55e;">Aprovada</span>
                                    @elseif($r->status === 'pendente')
                                        <span class="badge" style="background:#f59e0b1a;color:#f59e0b;">Pendente</span>
                                    @else
                                        <span class="badge" style="background:#ef44441a;color:#ef4444;">Negada</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">Sem reservas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection