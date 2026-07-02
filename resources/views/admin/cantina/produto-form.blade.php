{{-- resources/views/cantina/produto-form.blade.php --}}
@extends('layouts.app')

@section('titulo', isset($produto) ? 'Editar Produto' : 'Novo Produto')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
<style>
body { font-family: 'Plus Jakarta Sans', sans-serif; }

.form-header { margin-bottom: 1.75rem; }
.form-header h1 { font-family: 'Sora', sans-serif; font-size: 1.6rem; font-weight: 700; margin: 0 0 .2rem; }
.form-header p { font-size: .875rem; color: var(--text-muted); margin: 0; }

.form-card {
    background: var(--card-bg); border: 1px solid var(--border); border-radius: 14px;
    padding: 1.75rem; max-width: 640px;
}
.field-group { margin-bottom: 1.1rem; }
.field-lbl {
    font-size: .75rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
    color: var(--text-muted); margin-bottom: .4rem; display: block;
}
.field-ctrl {
    width: 100%; border: 1.5px solid var(--border); border-radius: 9px;
    padding: .6rem .9rem; font-size: .9rem; color: var(--text-main);
    font-family: 'Plus Jakarta Sans', sans-serif; background: transparent;
    transition: border-color .2s; outline: none;
}
.field-ctrl:focus { border-color: var(--primary); box-shadow: 0 0 0 3px color-mix(in srgb, var(--primary) 15%, transparent); }
.field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

.foto-preview {
    width: 120px; height: 120px; border-radius: 10px; object-fit: cover;
    border: 1px solid var(--border); margin-bottom: .75rem; display: block;
}
.form-actions { display: flex; gap: .6rem; margin-top: 1.5rem; }

.error-msg { font-size: .75rem; color: #ef4444; margin-top: .3rem; }
</style>
@endpush

@section('conteudo')

<div class="form-header">
    <h1>{{ isset($produto) ? '✏️ Editar Produto' : '➕ Novo Produto' }}</h1>
    <p>{{ isset($produto) ? 'Atualize as informações do produto.' : 'Cadastre um novo produto no cardápio.' }}</p>
</div>

@if($errors->any())
    <div class="alert alert-danger mb-3" style="max-width:640px;">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $erro)
                <li>{{ $erro }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-card">
    <form action="{{ isset($produto) ? route('admin.cantina.produtos.update', $produto->id) : route('admin.cantina.produtos.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($produto)) @method('PATCH') @endif

        @if(isset($produto) && $produto->foto)
            <img src="{{ asset('storage/'.$produto->foto) }}" alt="{{ $produto->nome }}" class="foto-preview">
        @endif

        <div class="field-group">
            <label class="field-lbl">Foto do produto</label>
            <input type="file" name="foto" class="field-ctrl" accept="image/*">
            <div class="error-msg">{{ $errors->first('foto') }}</div>
        </div>

        <div class="field-group">
            <label class="field-lbl">Categoria</label>
            <select name="categoria_id" class="field-ctrl" required>
                <option value="">Selecione...</option>
                @foreach($categorias as $categoria)
                    @php
                        $selecionada = old('categoria_id', $produto->categoria_id ?? request('categoria'));
                    @endphp
                    <option value="{{ $categoria->id }}" {{ (string) $selecionada === (string) $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nome }}
                    </option>
                @endforeach
            </select>
            <div class="error-msg">{{ $errors->first('categoria_id') }}</div>
        </div>

        <div class="field-group">
            <label class="field-lbl">Nome</label>
            <input type="text" name="nome" class="field-ctrl" maxlength="200"
                   value="{{ old('nome', $produto->nome ?? '') }}" required>
            <div class="error-msg">{{ $errors->first('nome') }}</div>
        </div>

        <div class="field-group">
            <label class="field-lbl">Descrição</label>
            <textarea name="descricao" class="field-ctrl" rows="3" maxlength="300">{{ old('descricao', $produto->descricao ?? '') }}</textarea>
            <div class="error-msg">{{ $errors->first('descricao') }}</div>
        </div>

        <div class="field-row">
            <div class="field-group">
                <label class="field-lbl">Preço (R$)</label>
                <input type="number" name="preco" class="field-ctrl" step="0.01" min="0"
                       value="{{ old('preco', $produto->preco ?? '') }}" required>
                <div class="error-msg">{{ $errors->first('preco') }}</div>
            </div>
            <div class="field-group">
                <label class="field-lbl">Estoque (unidades)</label>
                <input type="number" name="quantidade_estoque" class="field-ctrl" min="0"
                       value="{{ old('quantidade_estoque', $produto->quantidade_estoque ?? 0) }}" required>
                <div class="error-msg">{{ $errors->first('quantidade_estoque') }}</div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.cantina.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                {{ isset($produto) ? 'Salvar alterações' : 'Cadastrar produto' }}
            </button>
        </div>
    </form>
</div>

@endsection