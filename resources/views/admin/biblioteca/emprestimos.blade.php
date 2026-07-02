{{-- resources/views/admin/biblioteca/emprestimos.blade.php --}}
{{-- Controller: BibliotecaController@emprestimos --}}
@extends('layouts.admin')
@section('titulo', 'Empréstimos')

@push('styles')
<style>
    .emp-header { margin-bottom: 1.5rem; }
    .emp-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0; }
    .emp-header p  { font-size: .85rem; color: var(--text-secondary); margin: .25rem 0 0; }

    .emp-card {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 14px; overflow: hidden;
    }

    .emp-table { width: 100%; border-collapse: collapse; }
    .emp-table th {
        font-size: .75rem; font-weight: 600; color: var(--text-secondary);
        text-transform: uppercase; letter-spacing: .04em; padding: .75rem 1rem;
        border-bottom: 1px solid var(--border-color); text-align: left;
        background: var(--hover-bg);
    }
    .emp-table td {
        font-size: .85rem; color: var(--text-main); padding: .85rem 1rem;
        border-bottom: 1px solid var(--border-color); vertical-align: middle;
    }
    .emp-table tr:last-child td { border-bottom: none; }
    .emp-table tr:hover td { background: var(--hover-bg); }

    .emp-livro-titulo { font-weight: 600; color: var(--text-main); }
    .emp-livro-autor  { font-size: .78rem; color: var(--text-secondary); }

    .badge {
        display: inline-block; padding: .25rem .65rem; border-radius: 6px;
        font-size: .75rem; font-weight: 600; white-space: nowrap;
    }
    .badge-yellow { background: rgba(210,153,34,.15); color: #d29922; }
    .badge-green  { background: rgba(56,189,90,.15);  color: var(--badge-green); }
    .badge-red    { background: rgba(248,81,73,.15);  color: var(--badge-red); }

    .emp-actions { display: flex; gap: .5rem; flex-wrap: wrap; }
    .btn-acao {
        padding: .4rem .85rem; border-radius: 7px; border: 1px solid var(--border-color);
        background: var(--hover-bg); color: var(--text-main); font-size: .78rem;
        font-weight: 600; cursor: pointer; transition: background .2s;
    }
    .btn-acao:hover { background: var(--border-color); }
    .btn-acao-primary { background: var(--blue-primary); color: #fff; border: none; }
    .btn-acao-primary:hover { background: #388bfd; }
    .btn-acao-warning { background: rgba(210,153,34,.15); color: #d29922; border: none; }
    .btn-acao-warning:hover { opacity: .85; }

    .emp-empty {
        text-align: center; padding: 4rem 1rem; color: var(--text-secondary);
    }
    .emp-empty i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: var(--border-color); }
</style>
@endpush

@section('conteudo')

<div class="emp-header">
    <h1>Empréstimos</h1>
    <p>Acompanhe e gerencie os empréstimos da biblioteca.</p>
</div>

<div class="emp-card">
    <div class="table-responsive">
        <table class="emp-table">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Livro</th>
                    <th>Retirada</th>
                    <th>Devolução prevista</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($emprestimos as $emp)
                <tr>
                    <td>{{ $emp->usuario->name ?? $emp->user->name ?? '—' }}</td>
                    <td>
                        <div class="emp-livro-titulo">{{ $emp->livro->titulo ?? '—' }}</div>
                        <div class="emp-livro-autor">{{ $emp->livro->autor ?? '' }}</div>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($emp->data_emprestimo)->format('d/m/Y') }}</td>
                    <td>{{ $emp->data_prevista_devolucao ? \Carbon\Carbon::parse($emp->data_prevista_devolucao)->format('d/m/Y') : '—' }}</td>
                    <td>
                        @if($emp->status === 'devolvido')
                            <span class="badge badge-green">Devolvido</span>
                        @elseif($emp->status === 'atrasado')
                            <span class="badge badge-red">Atrasado</span>
                        @else
                            <span class="badge badge-yellow">Ativo</span>
                        @endif
                    </td>
                    <td>
                        <div class="emp-actions">
                            @if($emp->status !== 'devolvido')
                                <form action="{{ route('admin.biblioteca.devolver', $emp) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-acao btn-acao-primary">Marcar devolvido</button>
                                </form>
                                @if($emp->status !== 'atrasado')
                                <form action="{{ route('admin.biblioteca.atraso', $emp) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-acao btn-acao-warning">Marcar atraso</button>
                                </form>
                                @endif
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="emp-empty">
                            <i class="bi bi-journal-x"></i>
                            <p>Nenhum empréstimo encontrado.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($emprestimos->hasPages())
    <div style="padding: 16px 22px; border-top: 1px solid var(--border-color);">
        {{ $emprestimos->links() }}
    </div>
    @endif
</div>

@endsection