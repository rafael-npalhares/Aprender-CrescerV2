@extends('layouts.admin')
@section('titulo', 'Detalhes da Reserva')

@section('conteudo')

<h1 class="mb-4">Detalhes da Reserva</h1>

<div class="card">
    <div class="card-body">

```
    <div class="mb-3">
        <strong>Data:</strong>
        {{ \Carbon\Carbon::parse($reserva->data)->format('d/m/Y') }}
    </div>

    <div class="mb-3">
        <strong>Horário:</strong>
        {{ $reserva->horario_inicio }}
        às
        {{ $reserva->horario_fim }}
    </div>

    <div class="mb-3">
        <strong>Sala:</strong>
        {{ $reserva->sala->nome ?? 'Não informado' }}
    </div>

    <div class="mb-3">
        <strong>Equipamento:</strong>
        {{ $reserva->equipamento->nome ?? 'Não informado' }}
    </div>

    <div class="mb-3">
        <strong>Finalidade:</strong>
        <br>
        {{ $reserva->finalidade ?? 'Nenhuma finalidade informada.' }}
    </div>

    <div class="mb-3">
        <strong>Status:</strong>
        {{ ucfirst($reserva->status) }}
    </div>

    @if($reserva->motivo_rejeicao)
        <div class="alert alert-danger">
            <strong>Motivo da rejeição:</strong><br>
            {{ $reserva->motivo_rejeicao }}
        </div>
    @endif

    <a href="{{ route('professor.reservas.index') }}"
       class="btn btn-secondary">
        Voltar
    </a>

</div>
```

</div>

@endsection
