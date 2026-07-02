{{-- resources/views/biblioteca/show.blade.php --}}
{{-- Rota: biblioteca.livros.show (compartilhada) | Controller: BibliotecaController@showLivro --}}
@extends('layouts.admin')
@section('titulo', $livro->titulo)

@push('styles')
<style>
    .show-header {
        display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;
    }
    .show-header-back {
        display: inline-flex; align-items: center; justify-content: center;
        width: 36px; height: 36px; border-radius: 8px;
        background: var(--hover-bg); border: 1px solid var(--border-color);
        color: var(--text-main); text-decoration: none; font-size: 1rem;
        transition: background .2s, border-color .2s; flex-shrink: 0;
    }
    .show-header-back:hover { background: var(--blue-primary); border-color: var(--blue-primary); color: #fff; }

    .show-header-text h1 { font-size: 1.4rem; font-weight: 700; color: var(--text-main); margin: 0; }
    .show-header-text p  { font-size: .82rem; color: var(--text-secondary); margin: .15rem 0 0; }

    .show-header-actions { margin-left: auto; display: flex; gap: .6rem; }
    .btn-edit {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .55rem 1.1rem; border-radius: 8px; border: 1px solid var(--border-color);
        background: var(--hover-bg); color: var(--text-main); font-size: .85rem;
        font-weight: 600; text-decoration: none; transition: background .2s;
    }
    .btn-edit:hover { background: var(--border-color); }
    .btn-delete {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .55rem 1.1rem; border-radius: 8px; border: none;
        background: var(--badge-red); color: #fff; font-size: .85rem;
        font-weight: 600; cursor: pointer; transition: opacity .2s;
    }
    .btn-delete:hover { opacity: .85; }
    .btn-emprestar-header {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .55rem 1.1rem; border-radius: 8px; border: none;
        background: var(--blue-primary); color: #fff; font-size: .85rem;
        font-weight: 600; cursor: pointer; transition: background .2s;
    }
    .btn-emprestar-header:hover { background: #388bfd; }
    .btn-emprestar-header:disabled { background: var(--hover-bg); color: var(--text-secondary); cursor: not-allowed; }

    /* Detail card */
    .detail-layout {
        display: grid; grid-template-columns: 200px 1fr; gap: 1.5rem; align-items: start;
    }
    @media (max-width: 640px) { .detail-layout { grid-template-columns: 1fr; } }

    .detail-cover {
        width: 100%; aspect-ratio: 2/3; border-radius: 12px;
        background: linear-gradient(135deg, #1f6feb33, #58a6ff11);
        display: flex; align-items: center; justify-content: center;
        font-size: 3rem; color: var(--blue-primary);
        border: 1px solid var(--border-color);
    }

    .detail-card {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 14px; padding: 1.5rem;
    }

    .detail-meta { display: grid; grid-template-columns: 1fr 1fr; gap: .9rem 1.5rem; margin-bottom: 1.25rem; }
    .detail-meta-item label {
        font-size: .75rem; font-weight: 600; color: var(--text-secondary);
        text-transform: uppercase; letter-spacing: .04em; display: block; margin-bottom: .2rem;
    }
    .detail-meta-item span { font-size: .9rem; color: var(--text-main); }

    .stock-bar-wrap { margin-bottom: 1.25rem; }
    .stock-bar-wrap label {
        font-size: .75rem; font-weight: 600; color: var(--text-secondary);
        text-transform: uppercase; letter-spacing: .04em; display: block; margin-bottom: .5rem;
    }
    .stock-bar {
        height: 8px; border-radius: 99px; background: var(--hover-bg);
        overflow: hidden; position: relative;
    }
    .stock-bar-fill {
        height: 100%; border-radius: 99px; background: var(--blue-primary); transition: width .4s;
    }
    .stock-bar-legend {
        display: flex; justify-content: space-between; font-size: .77rem;
        color: var(--text-secondary); margin-top: .35rem;
    }

    /* Loans table (admin only) */
    .section-title {
        font-size: 1rem; font-weight: 700; color: var(--text-main);
        margin: 2rem 0 1rem;
    }
    .loans-table { width: 100%; border-collapse: collapse; }
    .loans-table th {
        font-size: .75rem; font-weight: 600; color: var(--text-secondary);
        text-transform: uppercase; letter-spacing: .04em; padding: .5rem .75rem;
        border-bottom: 1px solid var(--border-color); text-align: left;
    }
    .loans-table td {
        font-size: .85rem; color: var(--text-main); padding: .75rem;
        border-bottom: 1px solid var(--border-color);
    }
    .loans-table tr:last-child td { border-bottom: none; }
    .loans-table tr:hover td { background: var(--hover-bg); }
    .badge {
        display: inline-block; padding: .2rem .6rem; border-radius: 6px;
        font-size: .75rem; font-weight: 600;
    }
    .badge-yellow { background: rgba(210,153,34,.15); color: #d29922; }
    .badge-green  { background: rgba(56,189,90,.15);  color: var(--badge-green); }
    .badge-red    { background: rgba(248,81,73,.15);  color: var(--badge-red); }
</style>
@endpush

@section('conteudo')

<div class="show-header">
    <a href="{{ route('biblioteca.index') }}" class="show-header-back">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div class="show-header-text">
        <h1>{{ $livro->titulo }}</h1>
        <p>{{ $livro->autor }}</p>
    </div>
    <div class="show-header-actions">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.biblioteca.livros.edit', $livro) }}" class="btn-edit">
                <i class="bi bi-pencil-fill"></i> Editar
            </a>
            <form action="{{ route('admin.biblioteca.livros.destroy', $livro) }}" method="POST"
                  onsubmit="return confirm('Remover {{ addslashes($livro->titulo) }}? Esta ação não pode ser desfeita.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-delete">
                    <i class="bi bi-trash3-fill"></i> Remover
                </button>
            </form>
        @else
            <form action="{{ route('biblioteca.emprestar') }}" method="POST">
                @csrf
                <input type="hidden" name="livro_id" value="{{ $livro->id }}">
                <button type="submit" class="btn-emprestar-header" {{ $livro->qtd_disponivel <= 0 ? 'disabled' : '' }}>
                    <i class="bi bi-bookmark-plus-fill"></i>
                    {{ $livro->qtd_disponivel > 0 ? 'Emprestar' : 'Indisponível' }}
                </button>
            </form>
        @endif
    </div>
</div>

<div class="detail-layout">
    {{-- Capa placeholder --}}
    <div class="detail-cover">
        <i class="bi bi-book"></i>
    </div>

    {{-- Dados do livro --}}
    <div class="detail-card">
        <div class="detail-meta">
            <div class="detail-meta-item">
                <label>Cadastrado em</label>
                <span>{{ $livro->created_at->format('d/m/Y') }}</span>
            </div>
        </div>

        {{-- Barra de estoque --}}
        @php
            $pct = $livro->qtd_total > 0 ? ($livro->qtd_disponivel / $livro->qtd_total) * 100 : 0;
        @endphp
        <div class="stock-bar-wrap">
            <label>Disponibilidade</label>
            <div class="stock-bar">
                <div class="stock-bar-fill" style="width: {{ $pct }}%"></div>
            </div>
            <div class="stock-bar-legend">
                <span>{{ $livro->qtd_disponivel }} disponíveis</span>
                <span>{{ $livro->qtd_total - $livro->qtd_disponivel }} emprestado(s) · {{ $livro->qtd_total }} total</span>
            </div>
        </div>
    </div>
</div>

{{-- Empréstimos ativos — visível apenas para admin --}}
@if(auth()->user()->isAdmin() && isset($emprestimosAtivos) && $emprestimosAtivos->count())
<div class="section-title">Empréstimos ativos ({{ $emprestimosAtivos->count() }})</div>
<div class="detail-card" style="padding: 0; overflow: hidden;">
    <table class="loans-table">
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Retirada</th>
                <th>Devolução prevista</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emprestimosAtivos as $emp)
            <tr>
                <td>{{ $emp->usuario->name ?? $emp->user->name ?? '—' }}</td>
                <td>{{ $emp->data_emprestimo ? \Carbon\Carbon::parse($emp->data_emprestimo)->format('d/m/Y') : '—' }}</td>
                <td>{{ $emp->data_prevista_devolucao ? \Carbon\Carbon::parse($emp->data_prevista_devolucao)->format('d/m/Y') : '—' }}</td>
                <td>
                    @if($emp->status === 'devolvido')
                        <span class="badge badge-green">Devolvido</span>
                    @elseif($emp->status === 'atrasado')
                        <span class="badge badge-red">Atrasado</span>
                    @else
                        <span class="badge badge-yellow">Ativo</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection