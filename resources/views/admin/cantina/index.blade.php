{{-- resources/views/cantina/index.blade.php --}}
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

    .qty-stepper {
        display: flex; align-items: center; justify-content: space-between;
        border: 1.5px solid var(--border-color); border-radius: 8px; padding: .3rem .5rem; margin-bottom: .6rem;
    }
    .qty-stepper button {
        border: none; background: transparent; width: 26px; height: 26px;
        font-weight: 700; cursor: pointer; color: var(--text-main); font-size: 1rem;
    }
    .qty-stepper span { font-size: .85rem; font-weight: 700; color: var(--text-main); }

    .btn-add-cart {
        width: 100%; padding: .55rem; border-radius: 8px; border: none;
        background: var(--blue-primary); color: #fff; font-weight: 600; font-size: .85rem;
        cursor: pointer; transition: background .2s;
    }
    .btn-add-cart:hover { background: #388bfd; }
    .btn-disabled {
        width: 100%; padding: .55rem; border-radius: 8px; border: none;
        background: var(--hover-bg); color: var(--text-secondary); font-weight: 600; font-size: .85rem;
    }

    .empty-cat { grid-column: 1/-1; text-align: center; padding: 3.5rem 1rem; color: var(--text-secondary); }
    .empty-cat i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: var(--border-color); }

    /* carrinho flutuante */
    .cart-bar {
        position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
        background: var(--card-bg); border: 1px solid var(--border-color); color: var(--text-main);
        border-radius: 12px; padding: .85rem 1.3rem; display: none; align-items: center; gap: 1rem;
        box-shadow: 0 10px 30px rgba(0,0,0,.4); z-index: 1050;
    }
    .cart-bar.show { display: flex; }
    .cart-bar-count { font-size: .85rem; color: var(--text-secondary); }
    .cart-bar-total { font-weight: 700; }

    .cart-item-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: .5rem 0; border-bottom: 1px solid var(--border-color); font-size: .85rem;
    }
    .cart-item-row:last-child { border-bottom: none; }
</style>
@endpush

@section('conteudo')
@php
    $primeiraCategoria = $produtos->keys()->first();
@endphp

<div class="cant-header">
    <div>
        <h1><i class="bi bi-bag-fill" style="color:var(--blue-primary);"></i> Cantina</h1>
        <p>Confira os produtos disponíveis por categoria.</p>
    </div>
    <a href="{{ route('cantina.meus-pedidos') }}" class="lib-btn-secondary" style="display:inline-flex;align-items:center;gap:.5rem;background:var(--hover-bg);border:1px solid var(--border-color);color:var(--text-main);padding:.6rem 1.1rem;border-radius:8px;font-size:.85rem;font-weight:600;text-decoration:none;">
        <i class="bi bi-receipt"></i> Meus Pedidos
    </a>
</div>

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
                    <img src="{{ asset('storage/'.$item->foto) }}" alt="{{ $item->nome }}">
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

            @if($temEst)
                <div class="qty-stepper">
                    <button type="button" onclick="alterarQtd({{ $item->id }}, -1)">−</button>
                    <span id="qtd-{{ $item->id }}">0</span>
                    <button type="button" onclick="alterarQtd({{ $item->id }}, 1, {{ $item->quantidade_estoque }})">+</button>
                </div>
                <button type="button" class="btn-add-cart"
                        onclick="adicionarAoCarrinho({{ $item->id }}, '{{ addslashes($item->nome) }}', {{ $item->preco }}, {{ $item->quantidade_estoque }})">
                    <i class="bi bi-cart-plus-fill"></i> Adicionar
                </button>
            @else
                <button type="button" class="btn-disabled" disabled>Esgotado</button>
            @endif
        </div>
        @endforeach
    </div>
</div>
@empty
<div class="food-grid">
    <div class="empty-cat">
        <i class="bi bi-cup-straw"></i>
        <p>Nenhum produto disponível no momento.</p>
    </div>
</div>
@endforelse

{{-- CARRINHO FLUTUANTE --}}
<div class="cart-bar" id="cartBar">
    <span class="cart-bar-count" id="cartCount">0 itens</span>
    <span class="cart-bar-total" id="cartTotal">R$ 0,00</span>
    <button type="button" class="btn btn-primary btn-sm" onclick="abrirFinalizar()">Finalizar pedido</button>
</div>

{{-- MODAL: finalizar pedido --}}
<div class="modal fade" id="modalFinalizar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:480px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-cart-check-fill"></i> Finalizar pedido</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('cantina.pedidos.store') }}" method="POST" id="formFinalizar">
                @csrf
                <div class="modal-body d-flex flex-column gap-3">
                    <div id="resumoCarrinho"></div>
                    <div class="form-group mb-0">
                        <label class="form-label">Data de retirada</label>
                        <input type="date" name="data_retirada" class="form-control"
                               min="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div id="itensHidden"></div>
                </div>
                <div class="modal-footer gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                    <button type="submit" class="btn btn-primary">Confirmar pedido</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function trocarCategoria(slug, btn) {
    document.querySelectorAll('[id^="painel-"]').forEach(p => p.style.display = 'none');
    document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('painel-' + slug).style.display = '';
    btn.classList.add('active');
}

const carrinho = {};

function alterarQtd(produtoId, delta, estoqueMax) {
    const span = document.getElementById('qtd-' + produtoId);
    let atual = Math.max(0, parseInt(span.textContent, 10) + delta);
    if (estoqueMax !== undefined) atual = Math.min(atual, estoqueMax);
    span.textContent = atual;
}

function adicionarAoCarrinho(produtoId, nome, preco, estoqueMax) {
    const qtd = parseInt(document.getElementById('qtd-' + produtoId).textContent, 10);
    if (qtd <= 0) { alert('Selecione ao menos 1 unidade antes de adicionar.'); return; }

    if (carrinho[produtoId]) {
        carrinho[produtoId].quantidade += qtd;
    } else {
        carrinho[produtoId] = { nome, preco, quantidade: qtd, estoqueMax };
    }
    document.getElementById('qtd-' + produtoId).textContent = '0';
    atualizarCartBar();
}

function atualizarCartBar() {
    const ids = Object.keys(carrinho);
    const bar = document.getElementById('cartBar');
    if (ids.length === 0) { bar.classList.remove('show'); return; }

    let totalItens = 0, totalValor = 0;
    ids.forEach(id => { totalItens += carrinho[id].quantidade; totalValor += carrinho[id].quantidade * carrinho[id].preco; });

    document.getElementById('cartCount').textContent = totalItens + ' ite' + (totalItens > 1 ? 'ns' : 'm');
    document.getElementById('cartTotal').textContent = 'R$ ' + totalValor.toFixed(2).replace('.', ',');
    bar.classList.add('show');
}

function abrirFinalizar() {
    const ids = Object.keys(carrinho);
    if (ids.length === 0) return;

    const resumo = document.getElementById('resumoCarrinho');
    const hiddenWrap = document.getElementById('itensHidden');
    resumo.innerHTML = ''; hiddenWrap.innerHTML = '';

    let total = 0;
    ids.forEach((id, idx) => {
        const item = carrinho[id];
        const subtotal = (item.quantidade * item.preco).toFixed(2).replace('.', ',');
        total += item.quantidade * item.preco;

        resumo.innerHTML += `<div class="cart-item-row"><span>${item.quantidade}× ${item.nome}</span><span>R$ ${subtotal}</span></div>`;
        hiddenWrap.innerHTML += `<input type="hidden" name="itens[${idx}][produto_id]" value="${id}">
                                  <input type="hidden" name="itens[${idx}][quantidade]" value="${item.quantidade}">`;
    });

    resumo.innerHTML += `<div class="cart-item-row" style="font-weight:700;border-top:1px solid var(--border-color);margin-top:.5rem;padding-top:.5rem;">
                            <span>Total</span><span>R$ ${total.toFixed(2).replace('.', ',')}</span></div>`;

    new bootstrap.Modal(document.getElementById('modalFinalizar')).show();
}
</script>
@endpush