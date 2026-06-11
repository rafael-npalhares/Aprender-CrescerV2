@extends('layouts.admin')
@section('titulo', 'Nova Reserva')

@section('conteudo')

<div class="page-header">
    <div>
        <h1>Nova Reserva</h1>
        <p>Crie uma reserva no nome de um professor</p>
    </div>
    <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">← Voltar</a>
</div>

<div style="max-width: 620px;">
    <div class="card">
        <div style="padding: 32px;">

            <div style="display:flex; align-items:center; gap:14px; margin-bottom:28px; padding-bottom:20px; border-bottom:1px solid var(--border-color);">
                <div style="width:48px;height:48px;background:#e8f0fe;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;">📅</div>
                <div>
                    <div style="font-weight:700;font-size:1rem;color:var(--text-main);">Dados da reserva</div>
                    <div style="font-size:.85rem;color:var(--text-secondary);">A reserva será criada com status <strong>Aprovada</strong></div>
                </div>
            </div>

            <form action="{{ route('admin.reservas.store') }}" method="POST">
                @csrf

                {{-- Professor --}}
                <div class="form-group">
                    <label class="form-label" for="professor_id">Professor *</label>
                    <select id="professor_id" name="professor_id"
                            class="form-control @error('professor_id') is-invalid @enderror" required>
                        <option value="">Selecione o professor...</option>
                        @foreach($professores as $professor)
                            <option value="{{ $professor->id }}"
                                    {{ old('professor_id') == $professor->id ? 'selected' : '' }}>
                                {{ $professor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('professor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Data --}}
                <div class="form-group">
                    <label class="form-label" for="data">Data *</label>
                    <input type="date" id="data" name="data"
                           class="form-control @error('data') is-invalid @enderror"
                           value="{{ old('data', date('Y-m-d')) }}"
                           min="{{ date('Y-m-d') }}" required>
                    @error('data') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Horários --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label class="form-label" for="horario_inicio">Horário início *</label>
                        <input type="time" id="horario_inicio" name="horario_inicio"
                               class="form-control @error('horario_inicio') is-invalid @enderror"
                               value="{{ old('horario_inicio') }}" required>
                        @error('horario_inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="horario_fim">Horário fim *</label>
                        <input type="time" id="horario_fim" name="horario_fim"
                               class="form-control @error('horario_fim') is-invalid @enderror"
                               value="{{ old('horario_fim') }}" required>
                        @error('horario_fim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Sala --}}
                <div class="form-group">
                    <label class="form-label" for="sala_id">Sala <span style="color:var(--text-secondary);font-weight:400;">(opcional)</span></label>
                    <select id="sala_id" name="sala_id"
                            class="form-control @error('sala_id') is-invalid @enderror">
                        <option value="">Nenhuma sala</option>
                        @foreach($salas as $sala)
                            <option value="{{ $sala->id }}"
                                    {{ old('sala_id') == $sala->id ? 'selected' : '' }}>
                                {{ $sala->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('sala_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Equipamento --}}
                <div class="form-group">
                    <label class="form-label" for="equipamento_id">Equipamento <span style="color:var(--text-secondary);font-weight:400;">(opcional)</span></label>
                    <select id="equipamento_id" name="equipamento_id"
                            class="form-control @error('equipamento_id') is-invalid @enderror">
                        <option value="">Nenhum equipamento</option>
                        @foreach($equipamentos as $equipamento)
                            <option value="{{ $equipamento->id }}"
                                    {{ old('equipamento_id') == $equipamento->id ? 'selected' : '' }}>
                                {{ $equipamento->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('equipamento_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Finalidade --}}
                <div class="form-group">
                    <label class="form-label" for="finalidade">Finalidade <span style="color:var(--text-secondary);font-weight:400;">(opcional)</span></label>
                    <textarea id="finalidade" name="finalidade" rows="3"
                              class="form-control @error('finalidade') is-invalid @enderror"
                              placeholder="Descreva o motivo da reserva...">{{ old('finalidade') }}</textarea>
                    @error('finalidade') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div style="display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-color);">
                    <button type="submit" class="btn btn-primary">✓ Criar Reserva</button>
                    <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection