@extends('layouts.admin')
@section('titulo', 'Avisos')

@section('conteudo')

<div class="page-header">
    <div>
        <h1>Avisos</h1>
        <p>{{ $avisos->total() }} comunicado(s) no sistema</p>
    </div>
    <a href="{{ route('admin.avisos.create') }}" class="btn btn-primary">+ Novo Aviso</a>
</div>

{{-- Cards de avisos --}}
<div style="display: flex; flex-direction: column; gap: 14px;">

    @forelse($avisos as $aviso)

    <div style="background:var(--card-bg); border:1px solid var(--border-color); border-radius:12px; padding:20px 24px;
                border-left: 4px solid {{ $aviso->fixado ? 'var(--blue-primary)' : ($aviso->ativo ? 'var(--badge-green)' : 'var(--border-color)') }};">

        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px; flex-wrap:wrap;">

            {{-- Lado esquerdo: título + conteúdo --}}
            <div style="flex:1; min-width:0;">

                <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px; flex-wrap:wrap;">
                    @if($aviso->fixado)
                        <span style="font-size:.75rem; font-weight:700; color:var(--badge-blue); background:var(--badge-blue-bg); padding:2px 8px; border-radius:20px;">📌 Fixado</span>
                    @endif

                    @if(!$aviso->ativo)
                        <span style="font-size:.75rem; font-weight:700; color:var(--text-secondary); background:#8b949e22; padding:2px 8px; border-radius:20px;">Inativo</span>
                    @endif

                    <span style="font-size:.75rem; font-weight:600; padding:2px 10px; border-radius:20px;
                        {{ $aviso->visivel_para === 'todos' ? 'background:var(--badge-green-bg);color:var(--badge-green);' : ($aviso->visivel_para === 'professores' ? 'background:var(--badge-yellow-bg);color:var(--badge-yellow);' : 'background:var(--badge-blue-bg);color:var(--badge-blue);') }}">
                        {{ $aviso->visivel_para === 'todos' ? '🌐 Todos' : ($aviso->visivel_para === 'professores' ? '🧑‍🏫 Professores' : '🎒 Alunos') }}
                    </span>
                </div>

                <h3 style="font-size:1rem; font-weight:700; color:var(--text-main); margin:0 0 8px;">
                    {{ $aviso->titulo }}
                </h3>

                <p style="font-size:.875rem; color:var(--text-secondary); margin:0; line-height:1.6;
                           display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                    {{ $aviso->conteudo }}
                </p>

                <div style="display:flex; gap:16px; margin-top:10px; font-size:.78rem; color:var(--text-secondary);">
                    <span>👤 {{ $aviso->autor->name ?? '—' }}</span>
                    <span>📅 {{ $aviso->created_at->format('d/m/Y') }}</span>
                    @if($aviso->data_expiracao)
                        <span>⏰ Expira em {{ \Carbon\Carbon::parse($aviso->data_expiracao)->format('d/m/Y') }}</span>
                    @endif
                </div>
            </div>

            {{-- Lado direito: ações --}}
            <div style="display:flex; flex-direction:column; gap:6px; flex-shrink:0;">
                <a href="{{ route('admin.avisos.edit', $aviso) }}" class="btn btn-secondary btn-sm">✏️ Editar</a>

                <form action="{{ route('admin.avisos.destroy', $aviso) }}" method="POST"
                      onsubmit="return confirm('Excluir o aviso \'{{ addslashes($aviso->titulo) }}\'?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" style="width:100%;">🗑️ Excluir</button>
                </form>
            </div>

        </div>
    </div>

    @empty

    <div style="background:var(--card-bg); border:1px solid var(--border-color); border-radius:12px; padding:48px; text-align:center;">
        <div style="font-size:2.5rem; margin-bottom:12px;">🔔</div>
        <p style="color:var(--text-secondary); font-size:.95rem;">Nenhum aviso cadastrado ainda.</p>
        <a href="{{ route('admin.avisos.create') }}" class="btn btn-primary" style="margin-top:12px;">Criar primeiro aviso</a>
    </div>

    @endforelse

</div>

{{-- Paginação --}}
@if($avisos->hasPages())
<div style="margin-top:20px;">
    {{ $avisos->links() }}
</div>
@endif

@endsection