@extends('layouts.admin')
@section('titulo', 'Editar Turma')

@section('conteudo')

<div class="page-header">
    <div>
        <h1>Editar Turma</h1>
        <p>{{ $turma->serie }}º ano {{ $turma->turma }} — {{ ucfirst($turma->turno) }}</p>
    </div>
    <a href="{{ route('admin.turmas.index') }}" class="btn btn-secondary">← Voltar</a>
</div>

<div class="card" style="max-width: 500px;">
    <div style="padding: 28px;">
        <form action="{{ route('admin.turmas.update', $turma) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="serie">Série</label>
                <select id="serie" name="serie"
                        class="form-control @error('serie') is-invalid @enderror" required>
                    <option value="1" {{ old('serie', $turma->serie) == '1' ? 'selected' : '' }}>1º ano</option>
                    <option value="2" {{ old('serie', $turma->serie) == '2' ? 'selected' : '' }}>2º ano</option>
                    <option value="3" {{ old('serie', $turma->serie) == '3' ? 'selected' : '' }}>3º ano</option>
                </select>
                @error('serie') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="turma">Turma</label>
                <input type="text" id="turma" name="turma"
                       class="form-control @error('turma') is-invalid @enderror"
                       value="{{ old('turma', $turma->turma) }}"
                       maxlength="5" required>
                @error('turma') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="turno">Turno</label>
                <select id="turno" name="turno"
                        class="form-control @error('turno') is-invalid @enderror" required>
                    <option value="manha"  {{ old('turno', $turma->turno) === 'manha'  ? 'selected' : '' }}>Manhã</option>
                    <option value="tarde"  {{ old('turno', $turma->turno) === 'tarde'  ? 'selected' : '' }}>Tarde</option>
                    <option value="noite"  {{ old('turno', $turma->turno) === 'noite'  ? 'selected' : '' }}>Noite</option>
                </select>
                @error('turno') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="ano_letivo">Ano Letivo</label>
                <input type="number" id="ano_letivo" name="ano_letivo"
                       class="form-control @error('ano_letivo') is-invalid @enderror"
                       value="{{ old('ano_letivo', $turma->ano_letivo) }}"
                       min="2020" max="2099" required>
                @error('ano_letivo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                    <input type="checkbox" name="ativa" value="1"
                           class="form-check-input"
                           {{ old('ativa', $turma->ativa) ? 'checked' : '' }}>
                    <span class="form-label" style="margin:0;">Turma ativa</span>
                </label>
            </div>

            <div style="display:flex; gap:10px; margin-top: 8px;">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="{{ route('admin.turmas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection