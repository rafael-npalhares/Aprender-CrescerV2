{{-- resources/views/aluno/aviso.blade.php --}}
{{-- Rota: aluno.avisos | Controller: AlunoController@avisos --}}
{{-- Esperado: $avisos (paginado, já filtrado por visivel_para = 'alunos' ou 'todos') --}}

@extends('layouts.admin')
@section('titulo', 'Avisos')

@push('styles')
<style>
    .av-header { margin-bottom: 1.75rem; }
    .av-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0; }
    .av-header p  { font-size: .85rem; color: var(--text-secondary); margin: .25rem 0 0; }

    .av-list { display: flex; flex-direction: column; gap: 1rem; }

    .av-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-left: 4px solid var(--border-color);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        transition: border-color .2s;
    }
    .av-card.fixado { border-left-color: var(--blue-primary); }
    .av-card:hover  { border-color: var(--blue-primary); border-left-color: var(--blue-primary); }

    .av-top {
        display: flex; align-items: center; gap: .6rem;
        margin-bottom: .5rem; flex-wrap: wrap;
    }
    .av-pin {
        font-size: .72rem; font-weight: 700; letter-spacing: .04em;
        text-transform: uppercase; padding: .18rem .55rem; border-radius: 6px;
        background: rgba(88,166,255,.14); color: var(--blue-primary);
    }
    .av-titulo {
        font-size: .97rem; font-weight: 700; color: var(--text-main);
    }

    .av-conteudo {
        font-size: .875rem; color: var(--text-secondary);
        line-height: 1.65; white-space: pre-line; margin-bottom: .75rem;
    }

    .av-footer {
        display: flex; align-items: center; gap: 1.1rem;
        font-size: .76rem; color: var(--text-secondary); flex-wrap: wrap;
    }
    .av-footer i { margin-right: .25rem; }

    .av-expira {
        margin-left: auto; font-size: .74rem; font-weight: 600;
        color: #d29922; background: rgba(210,153,34,.12);
        padding: .18rem .55rem; border-radius: 6px;
    }

    .av-empty {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 12px; padding: 4rem 1rem;
        text-align: center; color: var(--text-secondary);
    }
    .av-empty i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: var(--border-color); }
    .av-empty p { margin: 0; font-size: .9rem; }
</style>
@endpush

@section('conteudo')

<div class="av-header">
    <h1>Avisos <span style="color:var(--blue-primary);">({{ $avisos->total() }})</span></h1>
    <p>Comunicados e informações importantes para você.</p>
</div>

<div class="av-list">
    @forelse($avisos as $aviso)

        <div class="av-card {{ $aviso->fixado ? 'fixado' : '' }}">

            <div class="av-top">
                @if($aviso->fixado)
                    <span class="av-pin"><i class="bi bi-pin-fill"></i> Fixado</span>
                @endif
                <span class="av-titulo">{{ $aviso->titulo }}</span>
            </div>

            <div class="av-conteudo">{{ $aviso->conteudo }}</div>

            <div class="av-footer">
                <span><i class="bi bi-calendar3"></i>{{ $aviso->created_at->format('d/m/Y') }}</span>

                @if($aviso->created_at->diffInDays() < 3)
                    <span style="color:var(--blue-primary); font-weight:600;">
                        <i class="bi bi-clock"></i>{{ $aviso->created_at->diffForHumans() }}
                    </span>
                @endif

                @if($aviso->autor)
                    <span><i class="bi bi-person"></i>{{ $aviso->autor->name ?? $aviso->autor }}</span>
                @endif

                @if($aviso->data_expiracao)
                    <span class="av-expira">
                        <i class="bi bi-hourglass-split"></i>
                        Expira em {{ \Carbon\Carbon::parse($aviso->data_expiracao)->format('d/m/Y') }}
                    </span>
                @endif
            </div>
        </div>

    @empty
        <div class="av-empty">
            <i class="bi bi-bell-slash"></i>
            <p>Nenhum aviso publicado no momento.</p>
        </div>
    @endforelse
</div>

@if($avisos->hasPages())
    <div style="margin-top: 2rem;">
        {{ $avisos->links('pagination::bootstrap-5') }}
    </div>
@endif

@endsection