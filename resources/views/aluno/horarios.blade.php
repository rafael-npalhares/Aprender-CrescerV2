{{-- resources/views/aluno/horarios.blade.php --}}
{{-- Rota: aluno.horarios | Controller: AlunoController@horarios --}}
{{--
    Esperado no controller:
    $grade    → coleção de GradeHorario filtrada pela turma do aluno logado
    $turma    → model Turma do aluno (para exibir o nome)

    Exemplo:
    $aluno = auth()->user();
    $turma = $aluno->turma;  // belongsTo Turma
    $grade = GradeHorario::where('turma_id', $turma->id)->with('professor')->get();
    return view('aluno.horarios', compact('grade', 'turma'));
--}}

@extends('layouts.admin')
@section('titulo', 'Meus Horários')

@push('styles')
<style>
    .hr-header { margin-bottom: 1.75rem; }
    .hr-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0; }
    .hr-header p  { font-size: .85rem; color: var(--text-secondary); margin: .25rem 0 0; }

    /* Badge da turma */
    .hr-turma-badge {
        display: inline-flex; align-items: center; gap: .5rem;
        background: var(--hover-bg); border: 1px solid var(--border-color);
        border-radius: 8px; padding: .45rem 1rem;
        font-size: .83rem; color: var(--text-secondary);
        margin-bottom: 1.5rem;
    }
    .hr-turma-badge strong { color: var(--text-main); }

    /* Wrapper scroll horizontal em telas pequenas */
    .hr-scroll { overflow-x: auto; }

    /* Tabela da grade */
    .hr-table {
        width: 100%; border-collapse: collapse;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px; overflow: hidden;
        min-width: 600px;
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
    .hr-table th:first-child { text-align: left; width: 70px; }

    .hr-table tbody tr:last-child td { border-bottom: none; }
    .hr-table tbody tr:nth-child(even) td { background: var(--hover-bg); }

    .hr-table td {
        padding: .7rem 1rem; border-bottom: 1px solid var(--border-color);
        border-right: 1px solid var(--border-color);
        vertical-align: middle; text-align: center;
    }
    .hr-table td:last-child { border-right: none; }

    /* Número da aula */
    .hr-aula-num {
        font-size: .8rem; font-weight: 700;
        color: var(--text-secondary); text-align: left;
        white-space: nowrap;
    }

    /* Célula com aula */
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
    .hr-cell-prof {
        font-size: .75rem; color: var(--text-secondary);
    }

    /* Célula vazia */
    .hr-cell-livre {
        font-size: .78rem; color: var(--border-color);
    }

    /* Empty state */
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
    <p>Grade de aulas da sua turma.</p>
</div>

@if(isset($turma) && $turma)
    <div class="hr-turma-badge">
        <i class="bi bi-mortarboard-fill" style="color:var(--blue-primary);"></i>
        <span>
            <strong>{{ $turma->serie }}º ano {{ $turma->turma }}</strong>
            &nbsp;·&nbsp; {{ ucfirst($turma->turno) }}
            &nbsp;·&nbsp; {{ $turma->ano_letivo }}
        </span>
    </div>
@endif

@php
    $dias = [
        'segunda' => 'Segunda',
        'terca'   => 'Terça',
        'quarta'  => 'Quarta',
        'quinta'  => 'Quinta',
        'sexta'   => 'Sexta',
    ];
    $numAulas = 6;

    // Organiza em [dia][numero_aula] para acesso O(1)
    $tabela = [];
    foreach (($grade ?? []) as $h) {
        $tabela[$h->dia_semana][$h->aula] = $h;
    }
@endphp

@if(isset($grade) && $grade->count())

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
                <td class="hr-aula-num">{{ $aula }}ª</td>

                @foreach($dias as $diaKey => $diaLabel)
                    @php $horario = $tabela[$diaKey][$aula] ?? null; @endphp
                    <td>
                        @if($horario)
                            <div class="hr-cell">
                                <div class="hr-cell-disc">{{ $horario->disciplina }}</div>
                                <div class="hr-cell-prof">
                                    <i class="bi bi-person"></i>
                                    {{ $horario->professor->name ?? '—' }}
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
    <p>Nenhum horário cadastrado para a sua turma ainda.</p>
</div>

@endif

@endsection