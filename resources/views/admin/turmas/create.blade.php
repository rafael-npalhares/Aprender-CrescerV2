@extends('layouts.admin')
@section('titulo', 'Nova Turma')

@section('conteudo')

<div class="page-header">
    <div>
        <h1>Nova Turma</h1>
        <p>Preencha os dados para criar uma nova turma</p>
    </div>
    <a href="{{ route('admin.turmas.index') }}" class="btn btn-secondary">← Voltar</a>
</div>

<div class="card" style="max-width: 500px;">
    <div style="padding: 28px;">
        <form action="{{ route('admin.turmas.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="serie">Série</label>
                <select id="serie" name="serie"
                        class="form-control @error('serie') is-invalid @enderror" required>
                    <option value="">Selecione...</option>
                    <option value="1" {{ old('serie') == '1' ? 'selected' : '' }}>1º ano</option>
                    <option value="2" {{ old('serie') == '2' ? 'selected' : '' }}>2º ano</option>
                    <option value="3" {{ old('serie') == '3' ? 'selected' : '' }}>3º ano</option>
                </select>
                @error('serie') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="turma">Turma</label>
                <input type="text" id="turma" name="turma"
                       class="form-control @error('turma') is-invalid @enderror"
                       value="{{ old('turma') }}"
                       placeholder="Ex: A, B, C" maxlength="5" required>
                @error('turma') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="turno">Turno</label>
                <select id="turno" name="turno"
                        class="form-control @error('turno') is-invalid @enderror" required>
                    <option value="">Selecione...</option>
                    <option value="manha"  {{ old('turno') === 'manha'  ? 'selected' : '' }}>Manhã</option>
                    <option value="tarde"  {{ old('turno') === 'tarde'  ? 'selected' : '' }}>Tarde</option>
                    <option value="noite"  {{ old('turno') === 'noite'  ? 'selected' : '' }}>Noite</option>
                </select>
                @error('turno') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="ano_letivo">Ano Letivo</label>
                <input type="number" id="ano_letivo" name="ano_letivo"
                       class="form-control @error('ano_letivo') is-invalid @enderror"
                       value="{{ old('ano_letivo', date('Y')) }}"
                       min="2020" max="2099" required>
                @error('ano_letivo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex; gap:10px; margin-top: 8px;">
                <button type="submit" class="btn btn-primary">Criar Turma</button>
                <a href="{{ route('admin.turmas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection