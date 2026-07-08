{{-- resources/views/dashboard/professor.blade.php --}}
{{-- Rota: professor.dashboard | Controller: ProfessorController@index --}}
{{-- Esperado: $avisos (top 5), $minhasReservas (top 5) --}}

@extends('layouts.admin')
@section('titulo', 'Dashboard')

@push('styles')
<style>
    .pd-header { margin-bottom: 1.75rem; }
    .pd-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0; }
    .pd-header p  { font-size: .85rem; color: var(--text-secondary); margin: .25rem 0 0; }

    .pd-shortcuts {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;
        margin-bottom: 2rem;
    }
    .pd-shortcut {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 12px; padding: 1.25rem; text-align: center;
        text-decoration: none; transition: border-color .2s;
    }
    .pd-shortcut:hover { border-color: var(--blue-primary); }
    .pd-shortcut i { font-size: 1.6rem; color: var(--blue-primary); display: block; margin-bottom: .5rem; }
    .pd-shortcut span { font-size: .85rem; font-weight: 600; color: var(--text-main); }

    .pd-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }

    .pd-box {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 12px; padding: 1.25rem 1.5rem;
    }
    .pd-box h2 {
        font-size: .95rem; font-weight: 700; color: var(--text-main);
        margin: 0 0 1rem;
    }

    .pd-item {
        padding: .75rem 0; border-bottom: 1px solid var(--border-color);
    }
    .pd-item:last-child { border-bottom: none; }
    .pd-item-titulo { font-size: .85rem; font-weight: 600; color: var(--text-main); }
    .pd-item-sub { font-size: .76rem; color: var(--text-secondary); margin-top: .2rem; }

    .pd-badge {
        font-size: .7rem; font-weight: 700; text-transform: uppercase;
        padding: .15rem .5rem; border-radius: 6px; letter-spacing: .03em;
    }
    .pd-badge.pendente { background: rgba(210,153,34,.14); color: #d29922; }
    .pd-badge.aprovada { background: rgba(63,185,80,.14); color: #3fb950; }
    .pd-badge.negada   { background: rgba(248,81,73,.14); color: #f85149; }

    .pd-empty { font-size: .82rem; color: var(--text-secondary); padding: .5rem 0; }

    @media (max-width: 900px) {
        .pd-shortcuts { grid-template-columns: repeat(2, 1fr); }
        .pd-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('conteudo')

<div class="pd-header">
    <h1>Olá, {{ auth()->user()->name }}</h1>
    <p>Bem-vindo ao seu painel.</p>
</div>

<div class="pd-shortcuts">
    <a href="{{ route('professor.horarios') }}" class="pd-shortcut">
        <i class="bi bi-calendar3"></i>
        <span>Meus Horários</span>
    </a>
    <a href="{{ route('professor.reservas.index') }}" class="pd-shortcut">
        <i class="bi bi-door-open"></i>
        <span>Reservas</span>
    </a>
    <a href="{{ route('biblioteca.index') }}" class="pd-shortcut">
        <i class="bi bi-book"></i>
        <span>Biblioteca</span>
    </a>
    <a href="{{ route('cantina.index') }}" class="pd-shortcut">
        <i class="bi bi-cup-hot"></i>
        <span>Cantina</span>
    </a>
</div>

<div class="pd-grid">

    <div class="pd-box">
        <h2>Avisos recentes</h2>

        @forelse($avisos as $aviso)
            <div class="pd-item">
                <div class="pd-item-titulo">{{ $aviso->titulo }}</div>
                <div class="pd-item-sub">{{ $aviso->created_at->format('d/m/Y') }}</div>
            </div>
        @empty
            <p class="pd-empty">Nenhum aviso publicado.</p>
        @endforelse

        @if($avisos->count())
            <div style="margin-top: .75rem;">
                <a href="{{ route('professor.avisos') }}" style="font-size:.8rem; color:var(--blue-primary);">Ver todos os avisos</a>
            </div>
        @endif
    </div>

    <div class="pd-box">
        <h2>Minhas reservas</h2>

        @forelse($minhasReservas as $reserva)
            <div class="pd-item" style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div class="pd-item-titulo">{{ \Carbon\Carbon::parse($reserva->data)->format('d/m/Y') }} · {{ $reserva->horario_inicio }} - {{ $reserva->horario_fim }}</div>
                    <div class="pd-item-sub">{{ $reserva->finalidade ?? 'Sem finalidade informada' }}</div>
                </div>
                <span class="pd-badge {{ $reserva->status }}">{{ $reserva->status }}</span>
            </div>
        @empty
            <p class="pd-empty">Nenhuma reserva feita.</p>
        @endforelse

        @if($minhasReservas->count())
            <div style="margin-top: .75rem;">
                <a href="{{ route('professor.reservas.index') }}" style="font-size:.8rem; color:var(--blue-primary);">Ver todas as reservas</a>
            </div>
        @endif
    </div>

</div>

@endsection