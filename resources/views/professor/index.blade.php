@extends('layouts.admin')
@section('titulo', 'Minhas Reservas')

@section('conteudo')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h1 class="h3 mb-1">Minhas Reservas</h1>
        <p class="text-muted mb-0">Gerencie suas solicitações de reserva.</p>
    </div>

    <a href="{{ route('professor.reservas.create') }}" class="btn btn-primary align-self-start align-self-md-auto">
        <i class="bi bi-plus-lg"></i>
        Nova Reserva
    </a>
</div>

<div class="card">
    <div class="card-body">

        @if($reservas->count())

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Local</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($reservas as $reserva)
                            <tr>
                                <td data-label="Data">
                                    {{ \Carbon\Carbon::parse($reserva->data)->format('d/m/Y') }}
                                </td>

                                <td data-label="Horário" class="text-nowrap">
                                    {{ $reserva->horario_inicio }} - {{ $reserva->horario_fim }}
                                </td>

                                <td data-label="Local">
                                    {{ $reserva->sala->nome ?? $reserva->equipamento->nome ?? '-' }}
                                </td>

                                <td data-label="Status">
                                    <span class="badge bg-secondary">
                                        {{ ucfirst($reserva->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $reservas->links() }}
            </div>

        @else

            <div class="text-center py-5">
                <i class="bi bi-calendar-x fs-1"></i>
                <p class="mt-3 mb-0">Nenhuma reserva encontrada.</p>
            </div>

        @endif

    </div>
</div>

@push('styles')
<style>
    /* Responsividade da tabela em telas pequenas */
    @media (max-width: 767.98px) {
        .table-responsive table thead {
            display: none;
        }

        .table-responsive table,
        .table-responsive table tbody,
        .table-responsive table tr,
        .table-responsive table td {
            display: block;
            width: 100%;
        }

        .table-responsive table tr {
            border: 1px solid var(--bs-border-color, #dee2e6);
            border-radius: 0.5rem;
            margin-bottom: 0.75rem;
            padding: 0.5rem 0.75rem;
        }

        .table-responsive table td {
            border: none;
            padding: 0.35rem 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: right;
        }

        .table-responsive table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--bs-secondary-color, #6c757d);
            text-align: left;
            padding-right: 0.75rem;
        }
    }
</style>
@endpush

@endsection