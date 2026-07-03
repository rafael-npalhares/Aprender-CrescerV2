{{-- resources/views/professor/reservas/create.blade.php --}}
{{-- Rota: professor.reservas.create | Controller: ReservaController@create --}}
{{-- Esperado: $salas, $equipamentos (disponíveis) --}}

@extends('layouts.admin')
@section('titulo', 'Nova Reserva')

@push('styles')
<style>
    .rf-header { margin-bottom: 1.75rem; }
    .rf-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0; }
    .rf-header p  { font-size: .85rem; color: var(--text-secondary); margin: .25rem 0 0; }

    .rf-box {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 12px; padding: 1.5rem; max-width: 560px;
    }

    .rf-row { margin-bottom: 1.1rem; }
    .rf-row label {
        display: block; font-size: .8rem; font-weight: 600;
        color: var(--text-secondary); margin-bottom: .4rem;
    }
    .rf-row-split { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

    .rf-input, .rf-select, .rf-textarea {
        width: 100%; background: var(--hover-bg); border: 1px solid var(--border-color);
        border-radius: 8px; padding: .6rem .75rem; font-size: .85rem;
        color: var(--text-main); box-sizing: border-box;
    }
    .rf-input:focus, .rf-select:focus, .rf-textarea:focus {
        outline: none; border-color: var(--blue-primary);
    }
    .rf-textarea { resize: vertical; min-height: 80px; }

    .rf-error { font-size: .76rem; color: #f85149; margin-top: .3rem; }

    .rf-actions { display: flex; gap: .75rem; margin-top: 1.5rem; }

    .rf-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        background: var(--blue-primary); color: #fff;
        font-size: .85rem; font-weight: 600;
        padding: .6rem 1.2rem; border-radius: 8px;
        border: none; cursor: pointer; text-decoration: none;
    }
    .rf-btn:hover { opacity: .9; }

    .rf-btn-secundario {
        background: transparent; border: 1px solid var(--border-color);
        color: var(--text-secondary);
    }
    .rf-btn-secundario:hover { border-color: var(--blue-primary); color: var(--blue-primary); }
</style>
@endpush

@section('conteudo')

<div class="rf-header">
    <h1>Nova Reserva</h1>
    <p>Solicite uma sala ou equipamento.</p>
</div>

<div class="rf-box">
    <form action="{{ route('professor.reservas.store') }}" method="POST">
        @csrf

        <div class="rf-row-split">
            <div class="rf-row">
                <label for="data">Data</label>
                <input type="date" name="data" id="data" class="rf-input" value="{{ old('data') }}" required>
                @error('data') <div class="rf-error">{{ $message }}</div> @enderror
            </div>
            <div></div>
        </div>

        <div class="rf-row-split">
            <div class="rf-row">
                <label for="horario_inicio">Horário início</label>
                <input type="time" name="horario_inicio" id="horario_inicio" class="rf-input" value="{{ old('horario_inicio') }}" required>
                @error('horario_inicio') <div class="rf-error">{{ $message }}</div> @enderror
            </div>
            <div class="rf-row">
                <label for="horario_fim">Horário fim</label>
                <input type="time" name="horario_fim" id="horario_fim" class="rf-input" value="{{ old('horario_fim') }}" required>
                @error('horario_fim') <div class="rf-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="rf-row">
            <label for="sala_id">Sala</label>
            <select name="sala_id" id="sala_id" class="rf-select">
                <option value="">Nenhuma</option>
                @foreach($salas as $sala)
                    <option value="{{ $sala->id }}" {{ old('sala_id') == $sala->id ? 'selected' : '' }}>
                        {{ $sala->nome }}
                    </option>
                @endforeach
            </select>
            @error('sala_id') <div class="rf-error">{{ $message }}</div> @enderror
        </div>

        <div class="rf-row">
            <label for="equipamento_id">Equipamento</label>
            <select name="equipamento_id" id="equipamento_id" class="rf-select">
                <option value="">Nenhum</option>
                @foreach($equipamentos as $equipamento)
                    <option value="{{ $equipamento->id }}" {{ old('equipamento_id') == $equipamento->id ? 'selected' : '' }}>
                        {{ $equipamento->nome }}
                    </option>
                @endforeach
            </select>
            @error('equipamento_id') <div class="rf-error">{{ $message }}</div> @enderror
        </div>

        <div class="rf-row">
            <label for="finalidade">Finalidade</label>
            <textarea name="finalidade" id="finalidade" class="rf-textarea" placeholder="Descreva o motivo da reserva (opcional)">{{ old('finalidade') }}</textarea>
            @error('finalidade') <div class="rf-error">{{ $message }}</div> @enderror
        </div>

        <div class="rf-actions">
            <button type="submit" class="rf-btn"><i class="bi bi-check-lg"></i> Solicitar reserva</button>
            <a href="{{ route('professor.reservas.index') }}" class="rf-btn rf-btn-secundario">Cancelar</a>
        </div>
    </form>
</div>

@endsection