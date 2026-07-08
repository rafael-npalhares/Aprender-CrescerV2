{{-- resources/views/biblioteca/index.blade.php --}}
@extends('layouts.admin')
@section('titulo', 'Biblioteca')

@push('styles')
<style>
    .lib-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;
    }
    .lib-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0; }
    .lib-header p  { font-size: .85rem; color: var(--text-secondary); margin: .2rem 0 0; }

    .lib-toolbar {
        display: flex; gap: .75rem; margin-bottom: 1.5rem; flex-wrap: wrap;
        align-items: center;
    }
    .lib-search { position: relative; flex: 1; min-width: 240px; max-width: 420px; }
    .lib-search i {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        color: var(--text-secondary); font-size: .95rem;
    }
    .lib-search input {
        width: 100%; background: var(--input-bg); border: 1.5px solid var(--border-color);
        border-radius: 8px; color: var(--text-main); font-size: .88rem;
        padding: .6rem .9rem .6rem 2.4rem; outline: none; transition: border-color .2s;
    }
    .lib-search input::placeholder { color: #3d4f6e; }
    .lib-search input:focus { border-color: var(--blue-primary); }

    .lib-btn-secondary {
        display: inline-flex; align-items: center; gap: .5rem;
        background: var(--hover-bg); border: 1px solid var(--border-color);
        color: var(--text-main); padding: .6rem 1.1rem; border-radius: 8px;
        font-size: .85rem; font-weight: 600; text-decoration: none; white-space: nowrap;
        transition: background .2s;
    }
    .lib-btn-secondary:hover { background: var(--blue-primary); color: #fff; }

    /* ── GRID DE LIVROS ── */
    .lib-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.25rem;
    }

    .book-card {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 14px; padding: 1.25rem; display: flex; flex-direction: column;
        transition: border-color .2s, transform .15s;
    }
    .book-card:hover { border-color: var(--blue-primary); transform: translateY(-2px); }

    .book-cover {
        width: 100%; height: 140px; border-radius: 10px; margin-bottom: 1rem;
        background: linear-gradient(135deg, #1f6feb33, #58a6ff11);
        display: flex; align-items: center; justify-content: center;
        font-size: 2.2rem; color: var(--blue-primary); flex-shrink: 0;
        text-decoration: none;
    }

    .book-title-link { text-decoration: none; }
    .book-title {
        font-weight: 700; font-size: .95rem; color: var(--text-main);
        margin-bottom: .25rem; line-height: 1.35;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .book-title-link:hover .book-title { color: var(--blue-primary); }
    .book-author {
        font-size: .8rem; color: var(--text-secondary); margin-bottom: .9rem;
    }

    .book-stock {
        display: flex; align-items: center; gap: .4rem;
        font-size: .78rem; margin-bottom: 1rem;
    }
    .book-stock .dot { width: 7px; height: 7px; border-radius: 50%; }
    .stock-ok   .dot { background: var(--badge-green); }
    .stock-ok   { color: var(--badge-green); }
    .stock-zero .dot { background: var(--badge-red); }
    .stock-zero { color: var(--badge-red); }

    .book-actions { margin-top: auto; display: flex; flex-direction: column; gap: .5rem; }
    .btn-emprestar {
        width: 100%; padding: .55rem; border-radius: 8px; border: none;
        background: var(--blue-primary); color: #fff; font-weight: 600;
        font-size: .85rem; cursor: pointer; transition: background .2s;
    }
    .btn-emprestar:hover { background: #388bfd; }
    .btn-emprestar:disabled {
        background: var(--hover-bg); color: var(--text-secondary); cursor: not-allowed;
    }
    .btn-detalhes {
        width: 100%; padding: .5rem; border-radius: 8px;
        border: 1px solid var(--border-color); background: transparent;
        color: var(--text-secondary); font-weight: 600; font-size: .8rem;
        text-align: center; text-decoration: none; transition: background .2s, color .2s;
    }
    .btn-detalhes:hover { background: var(--hover-bg); color: var(--text-main); }

    .lib-empty {
        text-align: center; padding: 4rem 1rem; color: var(--text-secondary);
        grid-column: 1 / -1;
    }
    .lib-empty i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: var(--border-color); }
</style>
@endpush

@section('conteudo')

<div class="lib-header">
    <div>
        <h1>Biblioteca <span style="color:var(--blue-primary);">({{ $livros->total() }})</span></h1>
        <p>Consulte o acervo disponível e solicite empréstimos.</p>
    </div>
</div>

<div class="lib-toolbar">
    <form method="GET" action="{{ auth()->user()->isAdmin() ? route('admin.biblioteca.index') : route('biblioteca.buscar') }}" class="lib-search">
        <i class="bi bi-search"></i>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por título ou autor...">
    </form>

    @if(auth()->user()->isAdmin())
        {{-- Ações exclusivas do admin: a proteção real está no middleware role:admin das rotas,
             isto aqui é só para não exibir ações inúteis a quem não pode usá-las. --}}
        <a href="{{ route('admin.biblioteca.emprestimos') }}" class="lib-btn-secondary">
            <i class="bi bi-journal-bookmark-fill"></i> Gerenciar Empréstimos
        </a>
        <a href="{{ route('admin.biblioteca.livros.create') }}" class="lib-btn-secondary" style="background:var(--blue-primary);color:#fff;">
            <i class="bi bi-plus-lg"></i> Novo livro
        </a>
    @else
        <a href="{{ route('biblioteca.meus-emprestimos') }}" class="lib-btn-secondary">
            <i class="bi bi-journal-bookmark-fill"></i> Meus empréstimos
        </a>
    @endif
</div>

<div class="lib-grid">
    @forelse($livros as $livro)
        <div class="book-card">
            <a href="{{ route('biblioteca.livros.show', $livro) }}" class="book-cover">
                <i class="bi bi-book"></i>
            </a>

            <a href="{{ route('biblioteca.livros.show', $livro) }}" class="book-title-link">
                <div class="book-title">{{ $livro->titulo }}</div>
            </a>
            <div class="book-author">{{ $livro->autor }}</div>

            <div class="book-stock {{ $livro->qtd_disponivel > 0 ? 'stock-ok' : 'stock-zero' }}">
                <span class="dot"></span>
                @if($livro->qtd_disponivel > 0)
                    {{ $livro->qtd_disponivel }} de {{ $livro->qtd_total }} disponíveis
                @else
                    Indisponível no momento
                @endif
            </div>

            <div class="book-actions">
                <a href="{{ route('biblioteca.livros.show', $livro) }}" class="btn-detalhes">
                    <i class="bi bi-eye"></i> Ver detalhes
                </a>

                @if(auth()->user()->isAdmin())
                    <div style="display:flex; gap:.5rem;">
                        <a href="{{ route('admin.biblioteca.livros.edit', $livro) }}"
                           class="btn-emprestar" style="background:var(--hover-bg);color:var(--text-main);text-decoration:none;text-align:center;">
                            <i class="bi bi-pencil-fill"></i> Editar
                        </a>
                        <form action="{{ route('admin.biblioteca.livros.destroy', $livro) }}" method="POST"
                              onsubmit="return confirmarAcao(this, 'Tem certeza que deseja remover \'{{ addslashes($livro->titulo) }}\'? Esta ação não pode ser desfeita.', 'Remover livro')" style="flex-shrink:0;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-emprestar" style="background:var(--badge-red);width:42px;">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <form action="{{ route('biblioteca.emprestar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="livro_id" value="{{ $livro->id }}">
                        <button type="submit" class="btn-emprestar" {{ $livro->qtd_disponivel <= 0 ? 'disabled' : '' }}>
                            <i class="bi bi-bookmark-plus-fill"></i>
                            {{ $livro->qtd_disponivel > 0 ? 'Emprestar' : 'Indisponível' }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="lib-empty">
            <i class="bi bi-book"></i>
            <p>Nenhum livro encontrado no acervo.</p>
        </div>
    @endforelse
</div>

@if($livros->hasPages())
<div style="margin-top:2rem;">
    {{ $livros->links('pagination::bootstrap-5') }}
</div>
@endif

@endsection