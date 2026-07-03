{{-- resources/views/professor/horarios.blade.php --}}
{{-- Rota: professor.horarios | Controller: ProfessorController@horarios --}}
{{-- Esperado: $horarios (coleção de GradeHorario do professor logado, com turma carregada) --}}

@extends('layouts.admin')
@section('titulo', 'Meus Horários')

@push('styles')
<style>
    .hr-header { margin-bottom: 1.75rem; }
    .hr-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0; }
    .hr-header p  { font-size: .85rem; color: var(--text-secondary); margin: .25rem 0 0; }

    .hr-scroll { overflow-x: auto; }

    .hr-table {
        width: 100%; border-collapse: collapse;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px; overflow: hidden;
        min-width: 700px;
    }

    .hr-table thead tr {
        background: var(--hover-bg);
    }
    .hr-table th {
        padding: .75rem 1rem; font-size: .75rem; font-weight: 700;
        color: var(--text-secondary); text-transform: uppercase;
        letter-spacing: .05em; text-align: center;
        border-bottom: 1px solid var(--border-color);
    }
    .hr-table th:first-child { text-align: left; width: 90px; }

    .hr-table tbody tr:last-child td { border-bottom: none; }
    .hr-table tbody tr:nth-child(even) td { background: var(--hover-bg); }

    .hr-table td {
        padding: .7rem 1rem; border-bottom: 1px solid var(--border-color);
        border-right: 1px solid var(--border-color);
        vertical-align: middle; text-align: center;
    }
    .hr-table td:last-child { border-right: none; }

    .hr-aula-num {
        font-size: .8rem; font-weight: 700;
        color: var(--text-secondary); text-align: left;
        white-space: nowrap;
    }
    .hr-aula-num small { display: block; font-weight: 500; color: var(--text-secondary); opacity: .8; }

    .hr-cell {
        background: rgba(88,166,255,.08);
        border-radius: 8px; padding: .55rem .7rem;
        display: inline-block; width: 100%;
        box-sizing: border-box;
    }
    .hr-cell-disc {
        font-size: .85rem; font-weight: 700; color: var(--text-main);
        margin-bottom: .2rem; line-height: 1.3;
    }
    .hr-cell-turma {
        font-size: .75rem; color: var(--text-secondary);
    }

    .hr-cell-livre {
        font-size: .78rem; color: var(--border-color);
    }

    .hr-empty {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 12px; padding: 4rem 1rem;
        text-align: center; color: var(--text-secondary);
    }
    .hr-empty i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: var(--border-color); }
    .hr-empty p { margin: 0; font-size: .9rem; }
</style>
@endpush

@section('conteudo')

<div class="hr-header">
    <h1>Meus Horários</h1>
    <p>Grade de aulas que você leciona.</p>
</div>

@php
    $dias = [
        'segunda' => 'Segunda',
        'terca'   => 'Terça',
        'quarta'  => 'Quarta',
        'quinta'  => 'Quinta',
        'sexta'   => 'Sexta',
    ];
    $numAulas = 6;

    // Referência: 1=7h00, 2=8h00, 3=9h00, 4=10h00, 5=11h00, 6=13h00
    $horasPorAula = [1 => '07:00', 2 => '08:00', 3 => '09:00', 4 => '10:00', 5 => '11:00', 6 => '13:00'];

    // Organiza em [dia][numero_aula] para acesso O(1)
    $tabela = [];
    foreach (($horarios ?? []) as $h) {
        $tabela[$h->dia_semana][$h->aula] = $h;
    }
@endphp

@if(isset($horarios) && $horarios->count())

<div class="hr-scroll">
    <table class="hr-table">
        <thead>
            <tr>
                <th>Aula</th>
                @foreach($dias as $label)
                    <th>{{ $label }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @for($aula = 1; $aula <= $numAulas; $aula++)
            <tr>
                <td class="hr-aula-num">
                    {{ $aula }}ª
                    <small>{{ $horasPorAula[$aula] ?? '' }}</small>
                </td>

                @foreach($dias as $diaKey => $diaLabel)
                    @php $horario = $tabela[$diaKey][$aula] ?? null; @endphp
                    <td>
                        @if($horario)
                            <div class="hr-cell">
                                <div class="hr-cell-disc">{{ $horario->disciplina }}</div>
                                <div class="hr-cell-turma">
                                    <i class="bi bi-people"></i>
                                    {{ $horario->turma->serie ?? '' }}º {{ $horario->turma->turma ?? '' }}
                                </div>
                            </div>
                        @else
                            <span class="hr-cell-livre">—</span>
                        @endif
                    </td>
                @endforeach
            </tr>
            @endfor
        </tbody>
    </table>
</div>

@else

<div class="hr-empty">
    <i class="bi bi-calendar-x"></i>
    <p>Você ainda não possui horários cadastrados.</p>
</div>

@endif

@endsection