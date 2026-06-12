@extends('layouts.admin')
@section('titulo', 'Biblioteca')

@section('conteudo')

<div class="page-header">
    <div>
        <h1>Biblioteca</h1>
        <p>{{ $livros->count() ?? 0 }} livro(s) disponível(is)</p>
    </div>

    <a href="{{ route('admin.biblioteca.create') }}" class="btn btn-primary">
        + Novo Livro
    </a>
</div>

<div style="display:flex; flex-direction:column; gap:14px;">

    @forelse($livros as $livro)

    <div style="
        background:#fff;
        border:1px solid var(--border-color);
        border-radius:12px;
        padding:20px 24px;
        border-left:4px solid var(--blue-primary);
    ">

        <div style="display:flex; justify-content:space-between; gap:16px; flex-wrap:wrap;">

            <div style="flex:1;">

                <h3 style="
                    margin:0 0 8px;
                    color:var(--text-main);
                    font-size:1rem;
                    font-weight:700;
                ">
                    📚 {{ $livro->titulo }}
                </h3>

                <p style="
                    margin:0;
                    color:var(--text-secondary);
                    font-size:.9rem;
                ">
                    {{ $livro->descricao }}
                </p>

                <div style="
                    display:flex;
                    gap:16px;
                    margin-top:10px;
                    color:#9ca3af;
                    font-size:.8rem;
                    flex-wrap:wrap;
                ">
                    <span>✍️ {{ $livro->autor }}</span>
                    <span>🏷️ {{ $livro->categoria }}</span>
                    <span>📦 {{ $livro->quantidade }} unidade(s)</span>
                </div>

            </div>

            <div style="
                display:flex;
                flex-direction:column;
                gap:6px;
            ">

                <a href="{{ route('admin.biblioteca.edit', $livro) }}"
                   class="btn btn-secondary btn-sm">
                    ✏️ Editar
                </a>

                <form action="{{ route('admin.biblioteca.destroy', $livro) }}"
                      method="POST"
                      onsubmit="return confirm('Excluir este livro?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-danger btn-sm"
                            style="width:100%;">
                        🗑️ Excluir
                    </button>

                </form>

            </div>

        </div>

    </div>

    @empty

    <div style="
        background:#fff;
        border:1px solid var(--border-color);
        border-radius:12px;
        padding:48px;
        text-align:center;
    ">
        <div style="font-size:3rem;">📚</div>

        <p style="
            margin-top:10px;
            color:var(--text-secondary);
        ">
            Nenhum livro cadastrado.
        </p>

        <a href="{{ route('admin.biblioteca.create') }}"
           class="btn btn-primary"
           style="margin-top:12px;">
            Cadastrar primeiro livro
        </a>
    </div>

    @endforelse

</div>

@endsection