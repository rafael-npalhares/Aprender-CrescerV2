@extends('layouts.admin')

@section('titulo', 'Dashboard')

@section('conteudo')

{{-- MÉTRICAS --}}
<div class="row g-3 mb-4">

    <div class="col-sm-6 col-xl-3">
        <div class="metric-card">
            <div class="metric-icon blue">👥</div>
            <div>
                <div class="metric-value">{{ $totalUsuarios ?? 0 }}</div>
                <div class="metric-label">Total de Usuários</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="metric-card">
            <div class="metric-icon green">🎒</div>
            <div>
                <div class="metric-value">{{ $totalAlunos ?? 0 }}</div>
                <div class="metric-label">Alunos</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="metric-card">
            <div class="metric-icon purple">🧑‍🏫</div>
            <div>
                <div class="metric-value">{{ $totalProfessores ?? 0 }}</div>
                <div class="metric-label">Professores</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="metric-card">
            <div class="metric-icon teal">🏫</div>
            <div>
                <div class="metric-value">{{ $totalTurmas ?? 0 }}</div>
                <div class="metric-label">Turmas Ativas</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="metric-card">
            <div class="metric-icon yellow">🔔</div>
            <div>
                <div class="metric-value">{{ $totalAvisosAtivos ?? 0 }}</div>
                <div class="metric-label">Avisos Ativos</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="metric-card">
            <div class="metric-icon red">📅</div>
            <div>
                <div class="metric-value">{{ $totalReservasPendentes ?? 0 }}</div>
                <div class="metric-label">Reservas Pendentes</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="metric-card">
            <div class="metric-icon blue">📚</div>
            <div>
                <div class="metric-value">{{ $totalEmprestimos ?? 0 }}</div>
                <div class="metric-label">Empréstimos Ativos</div>
            </div>
        </div>
    </div>

</div>

<div class="row g-4">

    {{-- ÚLTIMAS RESERVAS --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header-custom">
                <span class="card-title-custom">Últimas Reservas</span>
                <a href="{{ route('admin.reservas.index') }}" class="btn btn-outline btn-sm">Ver todas</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Professor</th>
                            <th>Recurso</th>
                            <th>Data</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimasReservas ?? [] as $reserva)
                        <tr>
                            <td class="fw-600">{{ $reserva->user->name ?? '—' }}</td>
                            <td class="text-muted-custom">{{ $reserva->recurso ?? '—' }}</td>
                            <td class="text-muted-custom">{{ \Carbon\Carbon::parse($reserva->data)->format('d/m/Y') }}</td>
                            <td>
                                @if($reserva->status === 'aprovada')
                                    <span class="badge-custom badge-success">✓ Aprovada</span>
                                @elseif($reserva->status === 'pendente')
                                    <span class="badge-custom badge-warning">⏳ Pendente</span>
                                @else
                                    <span class="badge-custom badge-danger">✗ Negada</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <div class="empty-icon">📅</div>
                                    <p>Nenhuma reserva encontrada.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ÚLTIMOS AVISOS --}}
    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-header-custom">
                <span class="card-title-custom">Últimos Avisos</span>
                <a href="{{ route('admin.avisos.index') }}" class="btn btn-outline btn-sm">Ver todos</a>
            </div>
            <div style="padding: 8px 0;">
                @forelse($ultimosAvisos ?? [] as $aviso)
                <div style="padding: 14px 22px; border-bottom: 1px solid var(--border);">
                    <div style="font-weight:600; font-size:13.5px; color:var(--text-main); margin-bottom:4px;">
                        {{ $aviso->titulo }}
                    </div>
                    <div style="font-size:12.5px; color:var(--text-muted);">
                        {{ \Carbon\Carbon::parse($aviso->created_at)->format('d/m/Y') }}
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon">🔔</div>
                    <p>Nenhum aviso ativo.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- AÇÕES RÁPIDAS --}}
        <div class="card">
            <div class="card-header-custom">
                <span class="card-title-custom">Ações Rápidas</span>
            </div>
            <div style="padding:16px; display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                <a href="{{ route('admin.usuarios.create') }}" class="action-card">
                    <div class="action-icon">👤</div>
                    <div class="action-label">Novo Usuário</div>
                </a>
                <a href="{{ route('admin.avisos.create') }}" class="action-card">
                    <div class="action-icon">📢</div>
                    <div class="action-label">Novo Aviso</div>
                </a>
                <a href="{{ route('admin.turmas.create') }}" class="action-card">
                    <div class="action-icon">🏫</div>
                    <div class="action-label">Nova Turma</div>
                </a>
                <a href="{{ route('admin.reservas.index') }}" class="action-card">
                    <div class="action-icon">✅</div>
                    <div class="action-label">Ver Reservas</div>
                </a>
            </div>
        </div>
    </div>

</div>

@endsection