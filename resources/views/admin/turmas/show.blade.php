@extends('layouts.admin')
@section('titulo', 'Alunos da Turma')

@section('conteudo')

<div class="page-header">
    <div>
        <h1>{{ $turma->nome_completo }}</h1>
        <p>Ano letivo {{ $turma->ano_letivo }} &middot; {{ $alunos->count() }} aluno(s) matriculado(s)</p>
    </div>
    <div style="display:flex; gap:6px;">
        <a href="{{ route('admin.turmas.edit', $turma) }}" class="btn btn-secondary">Editar Turma</a>
        <a href="{{ route('admin.turmas.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

<div class="card" style="margin-bottom:16px;">
    <div style="display:flex; gap:24px; flex-wrap:wrap;">
        <div>
            <span class="fw-600">Série:</span> {{ $turma->serie }}º Ano
        </div>
        <div>
            <span class="fw-600">Turma:</span> {{ $turma->turma }}
        </div>
        <div>
            <span class="fw-600">Turno:</span> {{ ucfirst($turma->turno) }}
        </div>
        <div>
            <span class="fw-600">Status:</span>
            @if($turma->ativa)
                <span class="badge-custom badge-success">Ativa</span>
            @else
                <span class="badge-custom badge-secondary">Inativa</span>
            @endif
        </div>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Data de Nascimento</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alunos as $aluno)
                <tr>
                    <td class="fw-600">{{ $aluno->matricula }}</td>
                    <td>{{ $aluno->user->name }}</td>
                    <td>{{ $aluno->user->email }}</td>
                    <td>{{ $aluno->data_nascimento?->format('d/m/Y') ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <div class="empty-icon">🎓</div>
                            <p>Nenhum aluno matriculado nesta turma.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection