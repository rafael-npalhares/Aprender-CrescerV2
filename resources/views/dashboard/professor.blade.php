{{-- resources/views/dashboard/professor.blade.php --}}
@extends('layouts.admin')
@section('titulo', 'Meu Perfil')

@push('styles')
<style>

    .perfil-card {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 16px; padding: 2rem; margin-bottom: 1.75rem;
        display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;
    }
    .perfil-avatar {
        width: 72px; height: 72px; border-radius: 50%;
        background: var(--blue-primary); color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; font-weight: 700; flex-shrink: 0;
    }
    .perfil-info h2 {
        font-size: 1.3rem; font-weight: 700; color: var(--text-main); margin: 0 0 .5rem;
    }
    .perfil-meta { display: flex; gap: 1.75rem; flex-wrap: wrap; }
    .perfil-meta-item { display: flex; flex-direction: column; gap: .15rem; }
    .perfil-meta-item .label {
        font-size: .7rem; text-transform: uppercase; letter-spacing: .06em;
        color: var(--text-secondary);
    }
    .perfil-meta-item .value {
        font-size: .92rem; font-weight: 600; color: var(--text-main);
    }


    .stats-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.25rem; margin-bottom: 1.75rem;
    }
    .stat-card {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 14px; padding: 1.25rem 1.5rem;
        display: flex; align-items: center; gap: 1rem;
    }
    .stat-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; flex-shrink: 0;
    }
    .stat-icon.blue   { background: var(--badge-blue-bg);   color: var(--badge-blue);   }
    .stat-icon.green  { background: var(--badge-green-bg);  color: var(--badge-green);  }
    .stat-icon.yellow { background: var(--badge-yellow-bg); color: var(--badge-yellow); }
    .stat-icon.red    { background: var(--badge-red-bg);    color: var(--badge-red);    }
    .stat-value { font-size: 1.4rem; font-weight: 700; color: var(--text-main); line-height: 1; }
    .stat-label { font-size: .8rem; color: var(--text-secondary); margin-top: .25rem; }


    .section-title {
        font-size: 1.05rem; font-weight: 700; color: var(--text-main);
        margin: 0 0 1rem; display: flex; align-items: center; gap: .5rem;
    }


    .aviso-item {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-left: 3px solid var(--blue-primary);
        border-radius: 10px; padding: 1rem 1.25rem; margin-bottom: .85rem;
    }
    .aviso-item h4 { font-size: .92rem; font-weight: 700; color: var(--text-main); margin: 0 0 .35rem; }
    .aviso-item p  { font-size: .82rem; color: var(--text-secondary); margin: 0; line-height: 1.5; }
    .aviso-item .data { font-size: .72rem; color: var(--text-secondary); margin-top: .5rem; display: block; }

    .reserva-item {
        display: flex; align-items: center; justify-content: space-between;
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 10px; padding: .9rem 1.25rem; margin-bottom: .75rem;
        gap: 1rem; flex-wrap: wrap;
    }
    .reserva-item .titulo  { font-weight: 600; font-size: .88rem; color: var(--text-main); }
    .reserva-item .sub     { font-size: .78rem; color: var(--text-secondary); margin-top: .2rem; }

    .rv-badge {
        font-size: .72rem; font-weight: 700; text-transform: uppercase;
        padding: .22rem .6rem; border-radius: 6px; letter-spacing: .03em; white-space: nowrap;
    }
    .rv-badge.pendente { background: rgba(210,153,34,.14); color: #d29922; }
    .rv-badge.aprovada { background: rgba(63,185,80,.14);  color: #3fb950; }
    .rv-badge.negada   { background: rgba(248,81,73,.14);  color: #f85149; }

    .quick-links { display: flex; gap: .65rem; flex-wrap: wrap; margin-bottom: 1.75rem; }
    .quick-link {
        display: inline-flex; align-items: center; gap: .4rem;
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 9px; padding: .45rem .9rem;
        font-size: .8rem; font-weight: 600; color: var(--text-secondary);
        text-decoration: none; transition: all .2s;
    }
    .quick-link:hover { border-color: var(--blue-primary); color: var(--blue-primary); }
</style>
@endpush

@section('conteudo')


<div class="perfil-card">
    <div class="perfil-avatar">
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
    </div>
    <div class="perfil-info">
        <h2>{{ auth()->user()->name }}</h2>
        <div class="perfil-meta">
            @php
                $professor = auth()->user()->professor;
            @endphp
            <div class="perfil-meta-item">
                <span class="label">Disciplina</span>
                <span class="value">{{ $professor->disciplina ?? '—' }}</span>
            </div>
            <div class="perfil-meta-item">
                <span class="label">Perfil</span>
                <span class="value">Professor</span>
            </div>
            <div class="perfil-meta-item">
                <span class="label">E-mail</span>
                <span class="value">{{ auth()->user()->email }}</span>
            </div>
        </div>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="bi bi-calendar-check-fill"></i></div>
        <div>
            <div class="stat-value">{{ $minhasReservas->where('status','aprovada')->count() }}</div>
            <div class="stat-label">Reservas aprovadas</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow"><i class="bi bi-hourglass-split"></i></div>
        <div>
            <div class="stat-value">{{ $minhasReservas->where('status','pendente')->count() }}</div>
            <div class="stat-label">Reservas pendentes</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="bi bi-megaphone-fill"></i></div>
        <div>
            <div class="stat-value">{{ $avisos->count() }}</div>
            <div class="stat-label">Avisos recentes</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="bi bi-x-circle-fill"></i></div>
        <div>
            <div class="stat-value">{{ $minhasReservas->where('status','negada')->count() }}</div>
            <div class="stat-label">Reservas negadas</div>
        </div>
    </div>
</div>

<div class="quick-links">
    <a href="{{ route('professor.reservas.create') }}" class="quick-link">
        <i class="bi bi-plus-lg"></i> Nova Reserva
    </a>
    <a href="{{ route('professor.avisos') }}" class="quick-link">
        <i class="bi bi-bell"></i> Avisos
    </a>
    <a href="{{ route('professor.horarios') }}" class="quick-link">
        <i class="bi bi-calendar3"></i> Meus Horários
    </a>
    <a href="{{ route('professor.reservas.index') }}" class="quick-link">
        <i class="bi bi-calendar-check"></i> Minhas Reservas
    </a>
    <a href="{{ route('biblioteca.index') }}" class="quick-link">
        <i class="bi bi-book"></i> Biblioteca
    </a>
    <a href="{{ route('cantina.index') }}" class="quick-link">
        <i class="bi bi-bag"></i> Cantina
    </a>
</div>


<div style="display:grid; grid-template-columns: 1.4fr 1fr; gap:1.5rem;">


    <div>
        <div class="section-title">
            <i class="bi bi-megaphone-fill" style="color:var(--blue-primary);"></i>
            Avisos Recentes
        </div>

        @forelse($avisos as $aviso)
            <div class="aviso-item">
                <h4>
                    @if($aviso->fixado)
                        <i class="bi bi-pin-fill me-1"
                           style="color:var(--blue-primary);font-size:.75rem;"></i>
                    @endif
                    {{ $aviso->titulo }}
                </h4>
                <p>{{ \Illuminate\Support\Str::limit($aviso->conteudo, 140) }}</p>
                <span class="data">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ $aviso->created_at->format('d/m/Y') }}
                </span>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-megaphone empty-icon"></i>
                <p>Nenhum aviso no momento.</p>
            </div>
        @endforelse

        @if($avisos->count())
            <a href="{{ route('professor.avisos') }}"
               style="font-size:.8rem; color:var(--blue-primary); text-decoration:none;">
                Ver todos os avisos →
            </a>
        @endif
    </div>


    <div>
        <div class="section-title">
            <i class="bi bi-calendar-check-fill" style="color:var(--badge-blue);"></i>
            Minhas Reservas
        </div>

        @forelse($minhasReservas as $reserva)
            <div class="reserva-item">
                <div>
                    <div class="titulo">
                        {{ \Carbon\Carbon::parse($reserva->data)->format('d/m/Y') }}
                        · {{ $reserva->horario_inicio }} – {{ $reserva->horario_fim }}
                    </div>
                    <div class="sub">
                        @if($reserva->sala)
                            <i class="bi bi-door-open me-1"></i>{{ $reserva->sala->nome }}
                        @endif
                        @if($reserva->equipamento)
                            <i class="bi bi-tools me-1"></i>{{ $reserva->equipamento->nome }}
                        @endif
                        @if($reserva->finalidade)
                            · {{ \Illuminate\Support\Str::limit($reserva->finalidade, 40) }}
                        @endif
                    </div>
                </div>
                <span class="rv-badge {{ $reserva->status }}">{{ $reserva->status }}</span>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-calendar-x empty-icon"></i>
                <p>Nenhuma reserva ainda.</p>
            </div>
        @endforelse

        <a href="{{ route('professor.reservas.index') }}"
           class="btn btn-secondary"
           style="width:100%; text-align:center; margin-top:.5rem;">
            Ver todas as reservas
        </a>
    </div>

</div>

@endsection