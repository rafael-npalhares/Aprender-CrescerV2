{{-- resources/views/cantina/index.blade.php (versão admin) --}}
@extends('layouts.admin')
@section('titulo', 'Cantina')

@push('styles')
<style>
    .cant-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;
    }
    .cant-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0; }
    .cant-header p  { font-size: .85rem; color: var(--text-secondary); margin: .2rem 0 0; }

    /* ── painel de categorias ── */
    .cat-panel {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 14px; padding: 1.1rem 1.3rem; margin-bottom: 1.5rem;
    }
    .cat-panel-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: .9rem;
    }
    .cat-panel-header h2 { font-size: .95rem; font-weight: 700; color: var(--text-main); margin: 0; }
    .cat-list { display: flex; flex-wrap: wrap; gap: .6rem; }
    .cat-pill {
        display: flex; align-items: center; gap: .5rem;
        background: var(--hover-bg); border: 1px solid var(--border-color);
        border-radius: 20px; padding: .35rem .5rem .35rem 1rem; font-size: .82rem;
        color: var(--text-main);
    }
    .cat-pill .qtd { color: var(--text-secondary); font-size: .74rem; }
    .cat-pill-actions { display: flex; gap: .25rem; }
    .cat-pill-actions button {
        border: none; background: transparent; width: 24px; height: 24px; border-radius: 50%;
        cursor: pointer; font-size: .78rem; display: flex; align-items: center; justify-content: center;
    }
    .cat-pill-actions .edit-btn { color: #58a6ff; }
    .cat-pill-actions .edit-btn:hover { background: #1f6feb22; }
    .cat-pill-actions .del-btn { color: var(--badge-red); }
    .cat-pill-actions .del-btn:hover { background: var(--badge-red-bg); }
    .cat-empty { font-size: .82rem; color: var(--text-secondary); }

    .cat-tabs {
        display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color); padding-bottom: .9rem;
    }
    .cat-tab {
        padding: .45rem 1.1rem; border-radius: 8px; font-size: .82rem; font-weight: 600;
        cursor: pointer; border: 1.5px solid var(--border-color); background: transparent;
        color: var(--text-secondary); transition: all .2s;
    }
    .cat-tab:hover { border-color: var(--blue-primary); color: #58a6ff; }
    .cat-tab.active { background: var(--blue-primary); border-color: var(--blue-primary); color: #fff; }

    .food-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.25rem; }

    .food-card {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 14px; padding: 1.1rem; display: flex; flex-direction: column;
        transition: border-color .2s, transform .15s; position: relative;
    }
    .food-card:hover { border-color: var(--blue-primary); transform: translateY(-2px); }
    .food-card.inativo { opacity: .6; }

    .food-cover {
        width: 100%; height: 130px; border-radius: 10px; margin-bottom: .9rem;
        background: linear-gradient(135deg, #1f6feb33, #58a6ff11);
        display: flex; align-items: center; justify-content: center;
        font-size: 2.2rem; color: var(--blue-primary); overflow: hidden;
    }
    .food-cover img { width: 100%; height: 100%; object-fit: cover; }
    .food-esgotado-badge {
        position: absolute; top: 12px; right: 12px;
        background: var(--badge-red-bg); color: var(--badge-red);
        font-size: .68rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase;
        padding: .25rem .6rem; border-radius: 20px;
    }
    .food-inativo-badge {
        position: absolute; top: 12px; left: 12px;
        background: #8b949e22; color: var(--text-secondary);
        font-size: .68rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase;
        padding: .25rem .6rem; border-radius: 20px;
    }

    .food-name { font-weight: 700; font-size: .93rem; color: var(--text-main); margin-bottom: .2rem; }
    .food-desc { font-size: .78rem; color: var(--text-secondary); margin-bottom: .8rem; line-height: 1.4; }

    .food-footer {
        display: flex; align-items: center; justify-content: space-between;
        padding-top: .7rem; border-top: 1px solid var(--border-color); margin-bottom: .8rem;
    }
    .food-price { font-weight: 700; font-size: 1.02rem; color: var(--text-main); }
    .food-price small { font-size: .7rem; color: var(--text-secondary); font-weight: 400; }
    .stock-pill { display: flex; align-items: center; gap: .35rem; font-size: .75rem; font-weight: 600; }
    .stock-pill .dot { width: 7px; height: 7px; border-radius: 50%; }
    .stock-full  { color: var(--badge-green); } .stock-full  .dot { background: var(--badge-green); }
    .stock-half  { color: var(--badge-yellow); } .stock-half  .dot { background: var(--badge-yellow); }
    .stock-empty { color: var(--badge-red); } .stock-empty .dot { background: var(--badge-red); }

    .empty-cat { grid-column: 1/-1; text-align: center; padding: 3.5rem 1rem; color: var(--text-secondary); }
    .empty-cat i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: var(--border-color); }
</style>
@endpush

@section('conteudo')
@php
    $primeiraCategoria = $produtos->keys()->first();
@endphp

<div class="cant-header">
    <div>
        <h1><i class="bi bi-bag-fill" style="color:var(--blue-primary);"></i> Cantina</h1>
        <p>Gerencie os produtos disponíveis por categoria.</p>
    </div>
    <div style="display:flex;gap:.5rem;">
        <a href="{{ route('admin.cantina.produtos.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Novo Produto
        </a>
        <a href="{{ route('admin.cantina.pedidos') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-receipt"></i> Pedidos
        </a>
    </div>
</div>

@if(session('sucesso'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('sucesso') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('erro'))
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('erro') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- ── PAINEL: GERENCIAR CATEGORIAS ── --}}
<div class="cat-panel">
    <div class="cat-panel-header">
        <h2><i class="bi bi-tags-fill" style="color:var(--blue-primary);"></i> Categorias</h2>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNovaCategoria">
            <i class="bi bi-plus-lg"></i> Nova categoria
        </button>
    </div>

    @if($categorias->count())
    <div class="cat-list">
        @foreach($categorias as $cat)
        <div class="cat-pill">
            <span>{{ $cat->nome }}</span>
            <span class="qtd">({{ $cat->produtos_count }})</span>
            <div class="cat-pill-actions">
                <button type="button" class="edit-btn" title="Editar"
                        data-bs-toggle="modal" data-bs-target="#modalEditarCategoria{{ $cat->id }}">
                    <i class="bi bi-pencil-fill"></i>
                </button>
                <form action="{{ route('admin.cantina.categorias.destroy', $cat->id) }}" method="POST"
                      onsubmit="return confirm('Excluir a categoria \'{{ addslashes($cat->nome) }}\'?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="del-btn" title="Excluir">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- modal de edição desta categoria --}}
        <div class="modal fade" id="modalEditarCategoria{{ $cat->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.cantina.categorias.update', $cat->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Editar categoria</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control" value="{{ $cat->nome }}" required maxlength="100">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
        <p class="cat-empty">Nenhuma categoria cadastrada ainda. Crie uma para poder cadastrar produtos.</p>
    @endif
</div>

{{-- modal: nova categoria --}}
<div class="modal fade" id="modalNovaCategoria" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.cantina.categorias.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Nova categoria</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" placeholder="Ex: Lanches, Bebidas..." required maxlength="100">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Criar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ── PRODUTOS ── --}}
@if($produtos->count())
<div class="cat-tabs">
    @foreach($produtos as $nomeCategoria => $itens)
        <button type="button" class="cat-tab {{ $nomeCategoria === $primeiraCategoria ? 'active' : '' }}"
                onclick="trocarCategoria('{{ Str::slug($nomeCategoria) }}', this)">
            {{ $nomeCategoria }}
        </button>
    @endforeach
</div>
@endif

@forelse($produtos as $nomeCategoria => $itens)
<div id="painel-{{ Str::slug($nomeCategoria) }}" {{ $nomeCategoria !== $primeiraCategoria ? 'style="display:none"' : '' }}>
    <div class="food-grid mb-4">
        @foreach($itens as $item)
        @php
            $nivel  = \App\Http\Controllers\Cantina\CantinaController::nivelEstoque($item->quantidade_estoque);
            $slbl   = match($nivel) { 'full' => 'Disponível', 'half' => 'Pouco estoque', default => 'Sem estoque' };
            $temEst = $item->quantidade_estoque > 0;
        @endphp

        <div class="food-card {{ !$item->ativo ? 'inativo' : '' }}">
            @if(!$item->ativo)
                <span class="food-inativo-badge">Inativo</span>
            @elseif(!$temEst)
                <span class="food-esgotado-badge">Esgotado</span>
            @endif

            <div class="food-cover">
                @if($item->foto)
                    <img src="{{ $item->foto_url }}" alt="{{ $item->nome }}">
                @else
                    <i class="bi bi-cup-straw"></i>
                @endif
            </div>

            <div class="food-name">{{ $item->nome }}</div>
            @if($item->descricao)
                <div class="food-desc">{{ $item->descricao }}</div>
            @endif

            <div class="food-footer">
                <div class="food-price"><small>R$</small> {{ number_format($item->preco, 2, ',', '.') }}</div>
                <div class="stock-pill stock-{{ $nivel }}"><span class="dot"></span>{{ $slbl }}</div>
            </div>

            <div style="display:flex;gap:.5rem;margin-top:auto;">
                <a href="{{ route('admin.cantina.produtos.edit', $item->id) }}"
                   class="btn btn-outline-secondary btn-sm" style="flex:1;text-align:center;">
                    <i class="bi bi-pencil-fill"></i> Editar
                </a>

                @if($item->ativo)
                    <form action="{{ route('admin.cantina.produtos.destroy', $item->id) }}"
                          method="POST" onsubmit="return confirm('Desativar produto?')" style="flex:1;">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm w-100" title="Desativar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.cantina.produtos.ativar', $item->id) }}"
                          method="POST" style="flex:1;">
                        @csrf @method('PATCH')
                        <button class="btn btn-outline-success btn-sm w-100" title="Reativar">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@empty
<div class="food-grid">
    <div class="empty-cat">
        <i class="bi bi-cup-straw"></i>
        <p>Nenhum produto cadastrado ainda.<br>
           <a href="{{ route('admin.cantina.produtos.create') }}" style="color:var(--blue-primary);">Cadastrar primeiro produto</a>
        </p>
    </div>
</div>
@endforelse

@endsection

@push('scripts')
<script>
function trocarCategoria(slug, btn) {
    document.querySelectorAll('[id^="painel-"]').forEach(p => p.style.display = 'none');
    document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('painel-' + slug).style.display = '';
    btn.classList.add('active');
}
</script>
@endpush