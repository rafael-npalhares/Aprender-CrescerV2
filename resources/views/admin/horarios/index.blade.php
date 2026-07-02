@extends('layouts.admin')
@section('titulo', 'Grade de Horários')

@section('conteudo')

<div class="page-header">
    <div>
        <h1>Grade de Horários</h1>
        <p>Selecione uma turma para visualizar e gerenciar os horários</p>
    </div>
    @if(request('turma_id'))
        <a href="{{ route('admin.grade.create') }}?turma_id={{ request('turma_id') }}" class="btn btn-primary">+ Adicionar Aula</a>
    @else
        <a href="{{ route('admin.grade.create') }}" class="btn btn-primary">+ Adicionar Aula</a>
    @endif
</div>

{{-- Seletor de turma --}}
<div class="card" style="margin-bottom:20px; padding:20px 24px;">
    <form method="GET" action="{{ route('admin.grade.index') }}"
          style="display:flex; align-items:flex-end; gap:12px; flex-wrap:wrap;">
        <div style="flex:1; min-width:200px;">
            <label class="form-label" for="turma_id">Selecione a turma</label>
            <select id="turma_id" name="turma_id" class="form-control"
                    onchange="this.form.submit()">
                <option value="">-- Escolha uma turma --</option>
                @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}"
                            {{ request('turma_id') == $turma->id ? 'selected' : '' }}>
                        {{ $turma->serie }}º ano {{ $turma->turma }} — {{ ucfirst($turma->turno) }} ({{ $turma->ano_letivo }})
                    </option>
                @endforeach
            </select>
        </div>
    </form>
</div>

@if(request('turma_id') && $turmaSelecionada)

{{-- Info da turma --}}
<div style="background:var(--badge-blue-bg); border:1px solid var(--border-color); border-radius:10px; padding:14px 20px; margin-bottom:20px; display:flex; align-items:center; gap:12px;">
    <span style="font-size:1.4rem;">🏫</span>
    <div>
        <strong style="color:var(--text-main);">{{ $turmaSelecionada->serie }}º ano {{ $turmaSelecionada->turma }}</strong>
        <span style="color:var(--text-secondary); margin-left:8px;">{{ ucfirst($turmaSelecionada->turno) }} · {{ $turmaSelecionada->ano_letivo }}</span>
    </div>
    <span style="margin-left:auto; font-size:.85rem; color:var(--text-secondary);">
        {{ $horarios->count() }} aula(s) cadastrada(s)
    </span>
</div>

{{-- Tabela da grade --}}
@php
    $dias = ['segunda' => 'Segunda', 'terca' => 'Terça', 'quarta' => 'Quarta', 'quinta' => 'Quinta', 'sexta' => 'Sexta'];
    $aulas = [1, 2, 3, 4, 5, 6];


    $grade = [];
    foreach ($horarios as $h) {
        $grade[$h->dia_semana][$h->aula] = $h;
    }
@endphp

<div style="overflow-x:auto;">
<table style="width:100%; border-collapse:collapse; background:var(--card-bg); border-radius:12px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,.3);">
    <thead>
        <tr>
            <th style="background:var(--sidebar-bg); color:#fff; padding:14px 18px; text-align:left; font-size:.8rem; text-transform:uppercase; letter-spacing:.06em; width:80px;">
                Aula
            </th>
            @foreach($dias as $key => $label)
            <th style="background:var(--sidebar-bg); color:#fff; padding:14px 18px; text-align:center; font-size:.8rem; text-transform:uppercase; letter-spacing:.06em;">
                {{ $label }}
            </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($aulas as $aula)
        <tr style="{{ $loop->even ? 'background:var(--hover-bg);' : 'background:var(--card-bg);' }}">

            {{-- Número da aula --}}
            <td style="padding:14px 18px; font-weight:700; font-size:.85rem; color:var(--text-secondary); border-right:2px solid var(--border-color); text-align:center;">
                {{ $aula }}ª
            </td>

            {{-- Células de cada dia --}}
            @foreach($dias as $diaKey => $diaLabel)
            @php $horario = $grade[$diaKey][$aula] ?? null; @endphp
            <td style="padding:10px 14px; border:1px solid var(--border-color); vertical-align:top; min-width:150px;">
                @if($horario)
                    <div style="background:var(--badge-blue-bg); border-radius:8px; padding:10px 12px;">
                        <div style="font-weight:700; font-size:.85rem; color:var(--text-main); margin-bottom:3px;">
                            {{ $horario->disciplina }}
                        </div>
                        <div style="font-size:.78rem; color:var(--text-secondary);">
                            {{ $horario->professor->name ?? '—' }}
                        </div>
                        <div style="display:flex; gap:6px; margin-top:8px;">
                            <a href="{{ route('admin.grade.edit', $horario) }}"
                               style="font-size:.72rem; padding:2px 8px; border-radius:4px; background:var(--card-bg); border:1px solid var(--blue-primary); color:var(--badge-blue); text-decoration:none;">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('admin.grade.destroy', $horario) }}" method="POST"
                                  onsubmit="return confirm('Remover {{ addslashes($horario->disciplina) }} de {{ $diaLabel }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        style="font-size:.72rem; padding:2px 8px; border-radius:4px; background:var(--card-bg); border:1px solid var(--badge-red); color:var(--badge-red); cursor:pointer;">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div style="text-align:center; padding:8px 0;">
                        <a href="{{ route('admin.grade.create') }}?turma_id={{ request('turma_id') }}&dia_semana={{ $diaKey }}&aula={{ $aula }}"
                           style="font-size:.78rem; color:var(--text-secondary); text-decoration:none; display:block;"
                           title="Adicionar aula">
                            + livre
                        </a>
                    </div>
                @endif
            </td>
            @endforeach

        </tr>
        @endforeach
    </tbody>
</table>
</div>

@elseif(!request('turma_id'))

{{-- Estado inicial: nenhuma turma selecionada --}}
<div style="background:var(--card-bg); border:1px solid var(--border-color); border-radius:12px; padding:56px; text-align:center;">
    <div style="font-size:3rem; margin-bottom:16px;">📋</div>
    <p style="color:var(--text-secondary); font-size:.95rem;">Selecione uma turma acima para visualizar a grade de horários.</p>
</div>

@endif

@endsection