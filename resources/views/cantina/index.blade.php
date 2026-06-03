@extends('layouts.app')

@section('titulo', 'Cantina')

@section('conteudo')

<div class="page-header">
    <div>
        <h1>Cantina</h1>
        <p>Cardápio e produtos disponíveis.</p>
    </div>
    <a href="{{ route('cantina.pedidos') }}" class="btn btn-secondary">
        🛒 Meus Pedidos
    </a>
</div>

@if(session('sucesso'))
    <div class="alert alert-success">✓ {{ session('sucesso') }}</div>
@endif

@if($produtos->isEmpty())
    <div class="card">
        <div class="empty-state" style="padding:60px 20px;">
            <div class="empty-icon">🍽️</div>
            <p>Nenhum produto disponível no momento.</p>
        </div>
    </div>
@else
    <div class="row g-3">
        @foreach($produtos as $produto)
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="card" style="height:100%; display:flex; flex-direction:column;">
                <div style="background:linear-gradient(135deg,#f59e0b,#ef4444); border-radius:12px 12px 0 0; padding:28px 20px; text-align:center; font-size:42px;">
                    {{ $produto->emoji ?? '🍔' }}
                </div>
                <div style="padding:16px; flex:1; display:flex; flex-direction:column; gap:6px;">
                    <div style="font-weight:700; font-size:14px; color:var(--text-main);">
                        {{ $produto->nome }}
                    </div>
                    @if($produto->descricao ?? null)
                    <div style="font-size:12.5px; color:var(--text-muted); line-height:1.5;">
                        {{ $produto->descricao }}
                    </div>
                    @endif
                    <div style="margin-top:auto; padding-top:12px; border-top:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
                        <div style="font-size:18px; font-weight:700; color:var(--primary);">
                            R$ {{ number_format($produto->preco, 2, ',', '.') }}
                        </div>
                        @if(($produto->estoque ?? 0) > 0)
                        <form action="{{ route('cantina.pedido.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                            <input type="hidden" name="quantidade" value="1">
                            <button type="submit" class="btn btn-primary btn-sm">+ Pedir</button>
                        </form>
                        @else
                            <span class="badge-custom badge-danger">Esgotado</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection