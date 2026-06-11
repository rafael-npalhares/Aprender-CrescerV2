@extends('layouts.admin')
@section('titulo', 'Editar Horário')

@section('conteudo')

<div class="page-header">
    <div>
        <h1>Editar Horário</h1>
        <p>{{ $grade->disciplina }} — {{ ucfirst($grade->dia_semana) }}, {{ $grade->aula }}ª aula</p>
    </div>
    <a href="{{ route('admin.grade.index', ['turma_id' => $grade->turma_id]) }}" class="btn btn-secondary">← Voltar</a>
</div>

<div style="max-width: 560px;">
    <div class="card">
        <div style="padding: 32px;">

            <div style="display:flex; align-items:center; gap:14px; margin-bottom:28px; padding-bottom:20px; border-bottom:1px solid var(--border-color);">
                <div style="width:48px;height:48px;background:#fef9c3;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;">✏️</div>
                <div>
                    <div style="font-weight:700;font-size:1rem;color:var(--text-main);">Editar aula</div>
                    <div style="font-size:.85rem;color:var(--text-secondary);">Turma {{ $grade->turma->serie ?? '?' }}º {{ $grade->turma->turma ?? '' }}</div>
                </div>
            </div>

            <form action="{{ route('admin.grade.update', $grade) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="turma_id">Turma *</label>
                    <select id="turma_id" name="turma_id"
                            class="form-control @error('turma_id') is-invalid @enderror" required>
                        @foreach($turmas as $turma)
                            <option value="{{ $turma->id }}"
                                    {{ old('turma_id', $grade->turma_id) == $turma->id ? 'selected' : '' }}>
                                {{ $turma->serie }}º ano {{ $turma->turma }} — {{ ucfirst($turma->turno) }}
                            </option>
                        @endforeach
                    </select>
                    @error('turma_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="professor_id">Professor *</label>
                    <select id="professor_id" name="professor_id"
                            class="form-control @error('professor_id') is-invalid @enderror" required>
                        @foreach($professores as $professor)
                            <option value="{{ $professor->id }}"
                                    {{ old('professor_id', $grade->professor_id) == $professor->id ? 'selected' : '' }}>
                                {{ $professor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('professor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="disciplina">Disciplina *</label>
                    <input type="text" id="disciplina" name="disciplina"
                           class="form-control @error('disciplina') is-invalid @enderror"
                           value="{{ old('disciplina', $grade->disciplina) }}"
                           maxlength="200" required>
                    @error('disciplina') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label class="form-label" for="dia_semana">Dia da semana *</label>
                        <select id="dia_semana" name="dia_semana"
                                class="form-control @error('dia_semana') is-invalid @enderror" required>
                            @foreach(['segunda'=>'Segunda-feira','terca'=>'Terça-feira','quarta'=>'Quarta-feira','quinta'=>'Quinta-feira','sexta'=>'Sexta-feira'] as $val => $label)
                                <option value="{{ $val }}"
                                        {{ old('dia_semana', $grade->dia_semana) === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('dia_semana') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="aula">Número da aula *</label>
                        <select id="aula" name="aula"
                                class="form-control @error('aula') is-invalid @enderror" required>
                            @for($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}"
                                        {{ old('aula', $grade->aula) == $i ? 'selected' : '' }}>
                                    {{ $i }}ª aula
                                </option>
                            @endfor
                        </select>
                        @error('aula') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div style="display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-color);">
                    <button type="submit" class="btn btn-primary">✓ Salvar Alterações</button>
                    <a href="{{ route('admin.grade.index', ['turma_id' => $grade->turma_id]) }}"
                       class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection