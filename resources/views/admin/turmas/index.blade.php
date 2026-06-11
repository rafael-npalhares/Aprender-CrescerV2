@extends('layouts.admin')
@section('titulo', 'Turmas')

@section('conteudo')

<div class="page-header">
    <div>
        <h1>Turmas</h1>
        <p>Gerencie as turmas do ano letivo</p>
    </div>
    <a href="{{ route('admin.turmas.create') }}" class="btn btn-primary">+ Nova Turma</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Série</th>
                    <th>Turma</th>
                    <th>Turno</th>
                    <th>Ano Letivo</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($turmas as $turma)
                <tr>
                    <td class="fw-600">{{ $turma->serie }}º ano</td>
                    <td>{{ $turma->turma }}</td>
                    <td>{{ ucfirst($turma->turno) }}</td>
                    <td>{{ $turma->ano_letivo }}</td>
                    <td>
                        @if($turma->ativa)
                            <span class="badge-custom badge-success">Ativa</span>
                        @else
                            <span class="badge-custom badge-secondary">Inativa</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('admin.turmas.edit', $turma) }}"
                               class="btn btn-secondary btn-sm">Editar</a>

                            <form action="{{ route('admin.turmas.destroy', $turma) }}"
                                  method="POST"
                                  onsubmit="return confirm('Excluir a turma {{ $turma->serie }}º {{ $turma->turma }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-icon">🏫</div>
                            <p>Nenhuma turma cadastrada.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection