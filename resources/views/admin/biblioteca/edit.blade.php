{{-- resources/views/admin/biblioteca/edit.blade.php --}}
@extends('layouts.admin')
@section('titulo', 'Editar Livro')

@push('styles')
<style>
    .form-header {
        display: flex; align-items: center; gap: 1rem;
        margin-bottom: 2rem;
    }
    .form-header-back {
        display: inline-flex; align-items: center; justify-content: center;
        width: 36px; height: 36px; border-radius: 8px;
        background: var(--hover-bg); border: 1px solid var(--border-color);
        color: var(--text-main); text-decoration: none; font-size: 1rem;
        transition: background .2s, border-color .2s; flex-shrink: 0;
    }
    .form-header-back:hover { background: var(--blue-primary); border-color: var(--blue-primary); color: #fff; }

    .form-header-text h1 { font-size: 1.4rem; font-weight: 700; color: var(--text-main); margin: 0; }
    .form-header-text p  { font-size: .82rem; color: var(--text-secondary); margin: .15rem 0 0; }

    .form-card {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 14px; padding: 2rem; max-width: 640px;
    }

    .form-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem 1.5rem;
    }
    .form-grid .span-2 { grid-column: 1 / -1; }

    .form-group { display: flex; flex-direction: column; gap: .4rem; }
    .form-group label {
        font-size: .8rem; font-weight: 600; color: var(--text-secondary);
        text-transform: uppercase; letter-spacing: .04em;
    }
    .form-group input,
    .form-group textarea,
    .form-group select {
        background: var(--input-bg); border: 1.5px solid var(--border-color);
        border-radius: 8px; color: var(--text-main); font-size: .9rem;
        padding: .65rem .9rem; outline: none; transition: border-color .2s;
        font-family: inherit;
    }
    .form-group input::placeholder,
    .form-group textarea::placeholder { color: #3d4f6e; }
    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus { border-color: var(--blue-primary); }
    .form-group textarea { resize: vertical; min-height: 90px; }

    .form-group .error {
        font-size: .78rem; color: var(--badge-red); margin-top: .2rem;
    }
    .form-group input.is-invalid,
    .form-group textarea.is-invalid { border-color: var(--badge-red); }

    .stock-info {
        display: inline-flex; align-items: center; gap: .5rem;
        background: var(--hover-bg); border: 1px solid var(--border-color);
        border-radius: 8px; padding: .5rem .9rem; font-size: .82rem;
        color: var(--text-secondary); margin-bottom: 1.5rem;
    }
    .stock-info strong { color: var(--text-main); }

    .form-actions {
        display: flex; gap: .75rem; justify-content: flex-end; margin-top: 1.75rem;
    }
    .btn-cancel {
        padding: .6rem 1.4rem; border-radius: 8px; border: 1px solid var(--border-color);
        background: var(--hover-bg); color: var(--text-main); font-size: .88rem;
        font-weight: 600; text-decoration: none; transition: background .2s;
    }
    .btn-cancel:hover { background: var(--border-color); }
    .btn-save {
        padding: .6rem 1.6rem; border-radius: 8px; border: none;
        background: var(--blue-primary); color: #fff; font-size: .88rem;
        font-weight: 600; cursor: pointer; transition: background .2s;
        display: inline-flex; align-items: center; gap: .45rem;
    }
    .btn-save:hover { background: #388bfd; }
</style>
@endpush

@section('conteudo')

<div class="form-header">
    <a href="{{ route('admin.biblioteca.index') }}" class="form-header-back">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div class="form-header-text">
        <h1>Editar livro</h1>
        <p>{{ $livro->titulo }}</p>
    </div>
</div>

<div class="form-card">

    <div class="stock-info">
        <i class="bi bi-box-seam"></i>
        Estoque atual: <strong>{{ $livro->qtd_disponivel }} disponíveis</strong> de {{ $livro->qtd_total }} exemplares
        &nbsp;·&nbsp;
        {{ $livro->qtd_total - $livro->qtd_disponivel }} emprestado(s)
    </div>

    <form action="{{ route('admin.biblioteca.livros.update', $livro) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-grid">

            {{-- Título --}}
            <div class="form-group span-2">
                <label for="titulo">Título</label>
                <input
                    type="text" id="titulo" name="titulo"
                    value="{{ old('titulo', $livro->titulo) }}"
                    placeholder="Ex: O Senhor dos Anéis"
                    class="{{ $errors->has('titulo') ? 'is-invalid' : '' }}"
                    autofocus
                >
                @error('titulo')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Autor --}}
            <div class="form-group span-2">
                <label for="autor">Autor</label>
                <input
                    type="text" id="autor" name="autor"
                    value="{{ old('autor', $livro->autor) }}"
                    placeholder="Ex: J. R. R. Tolkien"
                    class="{{ $errors->has('autor') ? 'is-invalid' : '' }}"
                >
                @error('autor')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Quantidade total --}}
            <div class="form-group span-2">
                <label for="qtd_total">Quantidade total</label>
                <input
                    type="number" id="qtd_total" name="qtd_total"
                    value="{{ old('qtd_total', $livro->qtd_total) }}"
                    min="{{ $livro->qtd_total - $livro->qtd_disponivel }}"
                    class="{{ $errors->has('qtd_total') ? 'is-invalid' : '' }}"
                >
                @error('qtd_total')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

        </div>

        <div class="form-actions">
            <a href="{{ route('admin.biblioteca.index') }}" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-save">
                <i class="bi bi-floppy-fill"></i> Salvar alterações
            </button>
        </div>
    </form>
</div>

@endsection