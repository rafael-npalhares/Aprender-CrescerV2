{{-- resources/views/cantina/produto-form.blade.php --}}
{{-- Usada tanto para criar quanto para editar um produto --}}
{{-- Controller: CantinaController@createProduto / editProduto --}}
{{-- Esperado: $categorias, e opcionalmente $produto (se edição) --}}

@extends('layouts.admin')
@section('titulo', isset($produto) ? 'Editar Produto' : 'Novo Produto')

@push('styles')
<style>
.pf-header {
    display: flex; align-items: center; gap: 1rem;
    margin-bottom: 1.75rem;
}
.pf-header a {
    color: var(--text-secondary); text-decoration: none; font-size: .85rem;
    display: flex; align-items: center; gap: .35rem;
    transition: color .2s;
}
.pf-header a:hover { color: var(--text-main); }
.pf-header h1 {
    font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;
}

.pf-card {
    background: var(--card-bg); border: 1px solid var(--border-color);
    border-radius: 14px; overflow: hidden;
    max-width: 780px;
}

.pf-section {
    padding: 1.5rem 1.75rem;
    border-bottom: 1px solid var(--border-color);
}
.pf-section:last-child { border-bottom: none; }

.pf-section-title {
    font-size: .72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .09em; color: var(--text-secondary);
    margin-bottom: 1.25rem;
}

.field-group { display: flex; flex-direction: column; gap: .4rem; margin-bottom: 1.1rem; }
.field-group:last-child { margin-bottom: 0; }
.field-lbl {
    font-size: .78rem; font-weight: 600; color: var(--text-secondary);
}
.field-lbl span { color: var(--badge-red); margin-left: 2px; }
.field-ctrl {
    background: var(--input-bg); border: 1.5px solid var(--border-color);
    border-radius: 9px; padding: .6rem .9rem;
    font-size: .88rem; color: var(--text-main);
    transition: border-color .2s; outline: none; width: 100%;
    font-family: inherit;
}
.field-ctrl:focus { border-color: var(--blue-primary); box-shadow: 0 0 0 3px rgba(31,111,235,.12); }
.field-ctrl option { background: var(--card-bg); }

.field-hint { font-size: .72rem; color: var(--text-secondary); margin-top: .2rem; }

.field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
@media(max-width:540px){ .field-row { grid-template-columns: 1fr; } }

.foto-upload-area {
    border: 2px dashed var(--border-color); border-radius: 12px;
    padding: 1.5rem; text-align: center; cursor: pointer;
    transition: border-color .2s, background .2s; position: relative;
}
.foto-upload-area:hover {
    border-color: var(--blue-primary);
    background: rgba(31,111,235,.04);
}
.foto-upload-area input[type="file"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
}
.foto-upload-icon { font-size: 2rem; margin-bottom: .5rem; color: var(--text-secondary); }
.foto-upload-label { font-size: .85rem; font-weight: 600; color: var(--text-main); margin-bottom: .25rem; }
.foto-upload-sub   { font-size: .75rem; color: var(--text-secondary); }

.foto-preview-wrap {
    display: none; position: relative;
    border-radius: 12px; overflow: hidden;
    border: 1.5px solid var(--border-color);
    max-height: 220px;
}
.foto-preview-wrap img {
    width: 100%; max-height: 220px; object-fit: cover; display: block;
}
.foto-preview-remove {
    position: absolute; top: 8px; right: 8px;
    background: rgba(0,0,0,.65); color: #fff; border: none;
    border-radius: 6px; padding: .25rem .55rem; font-size: .75rem;
    cursor: pointer; display: flex; align-items: center; gap: .3rem;
}
.foto-preview-remove:hover { background: rgba(248,81,73,.8); }

.foto-atual {
    border-radius: 12px; overflow: hidden;
    border: 1.5px solid var(--border-color); margin-bottom: 1rem;
}
.foto-atual img { width: 100%; max-height: 180px; object-fit: cover; display: block; }
.foto-atual-label {
    padding: .5rem .85rem; font-size: .72rem; color: var(--text-secondary);
    background: var(--hover-bg); display: flex; align-items: center; gap: .4rem;
}
.estoque-preview {
    display: inline-flex; align-items: center; gap: .5rem;
    margin-top: .5rem; font-size: .78rem; color: var(--text-secondary);
}
.estoque-dot {
    width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
    transition: background .3s;
}

.pf-footer {
    display: flex; align-items: center; justify-content: flex-end; gap: .75rem;
    padding: 1.25rem 1.75rem;
    border-top: 1px solid var(--border-color);
    background: var(--hover-bg);
}
</style>
@endpush

@section('conteudo')

@php $editando = isset($produto); @endphp

{{-- Cabeçalho com breadcrumb --}}
<div class="pf-header">
    <a href="{{ route('admin.cantina.index') }}">
        <i class="bi bi-arrow-left"></i> Voltar à cantina
    </a>
    <span style="color:var(--border-color);">/</span>
    <h1>{{ $editando ? 'Editar Produto' : 'Novo Produto' }}</h1>
</div>

@if($errors->any())
    <div style="background:rgba(248,81,73,.1);border:1px solid rgba(248,81,73,.3);
                border-radius:10px;padding:.85rem 1.1rem;margin-bottom:1.25rem;
                font-size:.85rem;color:#f85149;">
        <strong>Corrija os erros abaixo:</strong>
        <ul style="margin:.5rem 0 0 1rem;padding:0;">
            @foreach($errors->all() as $erro)
                <li>{{ $erro }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="pf-card">

    <form action="{{ $editando
            ? route('admin.cantina.produtos.update', $produto->id)
            : route('admin.cantina.produtos.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @if($editando) @method('PATCH') @endif

        {{-- ── INFORMAÇÕES BÁSICAS ── --}}
        <div class="pf-section">
            <div class="pf-section-title">Informações do produto</div>

            <div class="field-group">
                <label class="field-lbl">Categoria <span>*</span></label>
                <select name="categoria_id" class="field-ctrl" required>
                    <option value="" disabled {{ $editando ? '' : 'selected' }}>
                        Selecione uma categoria
                    </option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('categoria_id', $editando ? $produto->categoria_id : '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field-group">
                <label class="field-lbl">Nome do produto <span>*</span></label>
                <input type="text" name="nome" class="field-ctrl"
                       placeholder="Ex: Coxinha de Frango"
                       value="{{ old('nome', $editando ? $produto->nome : '') }}" required>
            </div>

            <div class="field-group">
                <label class="field-lbl">Descrição</label>
                <textarea name="descricao" class="field-ctrl" rows="2"
                          placeholder="Breve descrição do produto (opcional)"
                          style="resize:vertical;">{{ old('descricao', $editando ? $produto->descricao : '') }}</textarea>
            </div>

            <div class="field-row">
                <div class="field-group">
                    <label class="field-lbl">Preço (R$) <span>*</span></label>
                    <input type="number" name="preco" class="field-ctrl"
                           step="0.01" min="0" placeholder="0,00"
                           value="{{ old('preco', $editando ? $produto->preco : '') }}" required>
                </div>
                <div class="field-group">
                    <label class="field-lbl">Quantidade em estoque <span>*</span></label>
                    <input type="number" name="quantidade_estoque" id="qtdEstoque"
                           class="field-ctrl" min="0" placeholder="0"
                           value="{{ old('quantidade_estoque', $editando ? $produto->quantidade_estoque : '') }}"
                           required oninput="atualizarEstoquePreview(this.value)">
                    <div class="estoque-preview">
                        <div class="estoque-dot" id="estoqueDot"></div>
                        <span id="estoqueLabel">—</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── FOTO ── --}}
        <div class="pf-section">
            <div class="pf-section-title">Foto do produto</div>

            {{-- Foto atual (só na edição) --}}
            @if($editando && $produto->foto)
                <div class="foto-atual">
                    <img src="{{ $produto->foto_url }}"
                         alt="{{ $produto->nome }}" id="fotoAtualImg">
                    <div class="foto-atual-label">
                        <i class="bi bi-image"></i>
                        Foto atual — envie uma nova para substituir
                    </div>
                </div>
            @endif

            {{-- Preview da nova foto (aparece após selecionar) --}}
            <div class="foto-preview-wrap" id="fotoPreviewWrap">
                <img src="" alt="Preview" id="fotoPreviewImg">
                <button type="button" class="foto-preview-remove" onclick="removerFoto()">
                    <i class="bi bi-x"></i> Remover
                </button>
            </div>

            {{-- Área de upload --}}
            <div class="foto-upload-area" id="fotoUploadArea">
                <input type="file" name="foto" id="fotoInput"
                       accept="image/jpeg,image/png,image/webp,image/gif"
                       onchange="previewFoto(this)">
                <div class="foto-upload-icon">📷</div>
                <div class="foto-upload-label">Clique para selecionar uma imagem</div>
                <div class="foto-upload-sub">JPG, PNG ou WEBP · Máximo 2MB</div>
            </div>

            <div class="field-hint" style="margin-top:.65rem;">
                <i class="bi bi-info-circle me-1"></i>
                A imagem é salva automaticamente em
                <code style="color:var(--blue-primary);">public/img/cantina/</code>.
            </div>
        </div>

        {{-- ── RODAPÉ ── --}}
        <div class="pf-footer">
            <a href="{{ route('admin.cantina.index') }}"
               class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i>
                {{ $editando ? 'Salvar alterações' : 'Cadastrar produto' }}
            </button>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
function previewFoto(input) {
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];

    if (file.size > 2 * 1024 * 1024) {
        alert('A imagem não pode ultrapassar 2MB.');
        input.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        document.getElementById('fotoPreviewImg').src = e.target.result;
        document.getElementById('fotoPreviewWrap').style.display = 'block';
        document.getElementById('fotoUploadArea').style.display  = 'none';

        const atual = document.getElementById('fotoAtualImg');
        if (atual) atual.closest('.foto-atual').style.display = 'none';
    };
    reader.readAsDataURL(file);
}
function removerFoto() {
    document.getElementById('fotoInput').value = '';
    document.getElementById('fotoPreviewWrap').style.display = 'none';
    document.getElementById('fotoUploadArea').style.display  = '';


    const atual = document.getElementById('fotoAtualImg');
    if (atual) atual.closest('.foto-atual').style.display = '';
}

function atualizarEstoquePreview(valor) {
    const dot   = document.getElementById('estoqueDot');
    const label = document.getElementById('estoqueLabel');
    const qtd   = parseInt(valor, 10);

    if (isNaN(qtd) || valor === '') {
        dot.style.background = 'var(--border-color)';
        label.textContent = '—';
        return;
    }

    if (qtd <= 0) {
        dot.style.cssText = 'background:#ef4444;box-shadow:0 0 5px #ef444499;';
        label.textContent = 'Sem estoque — aparece como esgotado no cardápio';
    } else if (qtd <= 5) {
        dot.style.cssText = 'background:#f59e0b;box-shadow:0 0 5px #f59e0b99;';
        label.textContent = 'Pouco estoque';
    } else {
        dot.style.cssText = 'background:#22c55e;box-shadow:0 0 5px #22c55e99;';
        label.textContent = 'Disponível';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('qtdEstoque');
    if (input && input.value !== '') atualizarEstoquePreview(input.value);
});
</script>
@endpush