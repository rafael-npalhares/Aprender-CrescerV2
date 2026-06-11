@extends('layouts.admin')
@section('titulo', 'Novo Aviso')

@section('conteudo')

<div class="page-header">
    <div>
        <h1>Novo Aviso</h1>
        <p>Publique um novo comunicado para o sistema</p>
    </div>
    <a href="{{ route('admin.avisos.index') }}" class="btn btn-secondary">← Voltar</a>
</div>

<div class="card" style="max-width: 700px;">
    <div style="padding: 28px;">
        <form action="{{ route('admin.avisos.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo"
                       class="form-control @error('titulo') is-invalid @enderror"
                       value="{{ old('titulo') }}"
                       placeholder="Título do aviso" maxlength="200" required>
                @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="conteudo">Conteúdo</label>
                <textarea id="conteudo" name="conteudo" rows="5"
                          class="form-control @error('conteudo') is-invalid @enderror"
                          placeholder="Escreva o conteúdo do aviso..."
                          required>{{ old('conteudo') }}</textarea>
                @error('conteudo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="visivel_para">Visível para</label>
                <select id="visivel_para" name="visivel_para"
                        class="form-control @error('visivel_para') is-invalid @enderror" required>
                    <option value="todos"      {{ old('visivel_para') === 'todos'      ? 'selected' : '' }}>Todos</option>
                    <option value="professores"{{ old('visivel_para') === 'professores'? 'selected' : '' }}>Professores</option>
                    <option value="alunos"     {{ old('visivel_para') === 'alunos'     ? 'selected' : '' }}>Alunos</option>
                </select>
                @error('visivel_para') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="data_expiracao">Data de expiração <span style="color:var(--text-muted); font-weight:400;">(opcional)</span></label>
                <input type="date" id="data_expiracao" name="data_expiracao"
                       class="form-control @error('data_expiracao') is-invalid @enderror"
                       value="{{ old('data_expiracao') }}"
                       min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                @error('data_expiracao') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                    <input type="checkbox" name="fixado" value="1"
                           class="form-check-input"
                           {{ old('fixado') ? 'checked' : '' }}>
                    <span class="form-label" style="margin:0;">📌 Fixar aviso no topo</span>
                </label>
            </div>

            <div style="display:flex; gap:10px; margin-top: 8px;">
                <button type="submit" class="btn btn-primary">Publicar Aviso</button>
                <a href="{{ route('admin.avisos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection