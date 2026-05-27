{{-- resources/views/dashboard/admin.blade.php --}}
@extends('layouts.admin')
@section('titulo', 'Dashboard')

@section('conteudo')

@include('componentes.alerta')

{{-- Cards de métricas --}}
<div class="row g-3 mb-4">
    @php
        $metricas = [
            ['label' => 'Usuários',   'valor' => $totalUsuarios,          'icon' => 'people-fill',         'cor' => '#2d6ef7'],
            ['label' => 'Alunos',     'valor' => $totalAlunos,            'icon' => 'person-fill',          'cor' => '#22c55e'],
            ['label' => 'Professores','valor' => $totalProfessores,        'icon' => 'person-badge-fill',    'cor' => '#f59e0b'],
            ['label' => 'Turmas',     'valor' => $totalTurmas,            'icon' => 'collection-fill',      'cor' => '#8b5cf6'],
            ['label' => 'Avisos Ativos','valor'=> $totalAvisosAtivos,     'icon' => 'megaphone-fill',       'cor' => '#06b6d4'],
            ['label' => 'Reservas Pendentes','valor'=>$totalReservasPendentes,'icon'=>'calendar-check-fill','cor' => '#f59e0b'],
            ['label' => 'Empréstimos','valor' => $totalEmprestimos,       'icon' => 'book-fill',            'cor' => '#ef4444'],
        ];
    @endphp

    @foreach($metricas as $m)
        <div class="col-6 col-md-4 col-xl-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:48px;height:48px;background:{{ $m['cor'] }}1a;">
                        <i class="bi bi-{{ $m['icon'] }}" style="color:{{ $m['cor'] }};font-size:1.3rem;"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-4 lh-1" style="color:#1a2238;">{{ $m['valor'] }}</div>
                        <div style="font-size:.8rem;color:#8899bb;">{{ $m['label'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3">
    {{-- Últimas Reservas --}}
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3"
                 style="border-bottom:1px solid #e8eaf0;">
                <span class="fw-semibold" style="color:#1a2238;">Últimas Reservas</span>
                <a href="{{ route('admin.reservas.index') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Solicitante</th>
                            <th>Recurso</th>
                            <th>Data</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimasReservas as $reserva)
                            <tr>
                                <td>{{ $reserva->user->name ?? '—' }}</td>
                                <td>{{ $reserva->recurso ?? '—' }}</td>
                                <td>{{ $reserva->data_reserva ?? '—' }}</td>
                                <td>
                                    @if($reserva->status === 'aprovada')
                                        <span class="badge" style="background:#22c55e1a;color:#22c55e;">Aprovada</span>
                                    @elseif($reserva->status === 'pendente')
                                        <span class="badge" style="background:#f59e0b1a;color:#f59e0b;">Pendente</span>
                                    @else
                                        <span class="badge" style="background:#ef44441a;color:#ef4444;">Negada</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">Nenhuma reserva ainda.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Últimos Avisos --}}
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3"
                 style="border-bottom:1px solid #e8eaf0;">
                <span class="fw-semibold" style="color:#1a2238;">Avisos Recentes</span>
                <a href="{{ route('admin.avisos.index') }}" class="btn btn-sm btn-outline-primary">Ver todos</a>
            </div>
            <div class="card-body">
                @forelse($ultimosAvisos as $aviso)
                    @include('componentes.card-aviso', ['aviso' => $aviso])
                @empty
                    <p class="text-muted text-center mt-3">Nenhum aviso ativo.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Ações rápidas --}}
<div class="card mt-3">
    <div class="card-body">
        <p class="fw-semibold mb-3" style="color:#1a2238;">Ações Rápidas</p>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-person-plus-fill me-1"></i>Novo Usuário
            </a>
            <a href="{{ route('admin.avisos.create') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-megaphone me-1"></i>Novo Aviso
            </a>
            <a href="{{ route('admin.turmas.create') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Nova Turma
            </a>
            <a href="{{ route('admin.reservas.index') }}" class="btn btn-outline-warning btn-sm">
                <i class="bi bi-calendar-check me-1"></i>Ver Reservas Pendentes
            </a>
        </div>
    </div>
</div>

@endsection