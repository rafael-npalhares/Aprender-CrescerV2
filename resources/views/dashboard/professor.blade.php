@extends('layouts.app')

@section('titulo', 'Dashboard')

@section('conteudo')

<div class="page-header">
    <div>
        <h1>Olá, {{ auth()->user()->name ?? 'Professor' }} 👋</h1>
        <p>Bem-vindo de volta ao sistema escolar.</p>
    </div>
    <a href="{{ route('professor.reservas.create') }}" class="btn btn-primary">
        + Nova Reserva
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-md-4">
        <div class="metric-card">
            <div class="metric-icon blue">📅</div>
            <div>
                <div class="metric-value">{{ isset($minhasReservas) ? $minhasReservas->count() : 0 }}</div>
                <div class="metric-label">Minhas Reservas</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="metric-card">
            <div class="metric-icon yellow">🔔</div>
            <div>
                <div class="metric-value">{{ isset($avisos) ? $avisos->count() : 0 }}</div>
                <div class="metric-label">Avisos Ativos</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="metric-card">
            <div class="metric-icon green">📋</div>
            <div>
                <div class="metric-value">{{ isset($meuHorario) ? count($meuHorario) : 0 }}</div>
                <div class="metric-label">Aulas Hoje</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- AVISOS --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header-custom">
                <span class="card-title-custom">Avisos Recentes</span>
                <a href="{{ route('professor.avisos') }}" class="btn btn-outline btn-sm">Ver todos</a>
            </div>
            <div style="padding:8px 0;">
                @forelse($avisos ?? [] as $aviso)
                <div style="padding:14px 22px; border-bottom:1px solid var(--border);">
                    <div style="font-weight:600; font-size:13.5px; margin-bottom:4px;">{{ $aviso->titulo }}</div>
                    <div style="font-size:12.5px; color:var(--text-muted); overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;">
                        {{ $aviso->conteudo }}
                    </div>
                    <div style="font-size:11.5px; color:var(--text-muted); margin-top:6px;">
                        {{ \Carbon\Carbon::parse($aviso->created_at)->format('d/m/Y') }}
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon">🔔</div>
                    <p>Nenhum aviso no momento.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- MINHAS RESERVAS --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header-custom">
                <span class="card-title-custom">Minhas Reservas</span>
                <a href="{{ route('professor.reservas.create') }}" class="btn btn-primary btn-sm">+ Nova</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Recurso</th>
                            <th>Data</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($minhasReservas ?? [] as $reserva)
                        <tr>
                            <td class="fw-600">{{ $reserva->recurso ?? '—' }}</td>
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
                            <td colspan="3">
                                <div class="empty-state">
                                    <div class="empty-icon">📅</div>
                                    <p>Nenhuma reserva ainda.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection