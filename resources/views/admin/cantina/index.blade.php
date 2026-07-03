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

        <div class="food-card">
            @if(!$temEst)
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
                <form action="{{ route('admin.cantina.produtos.destroy', $item->id) }}"
                      method="POST" onsubmit="return confirm('Remover produto?')" style="flex:1;">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm w-100">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
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