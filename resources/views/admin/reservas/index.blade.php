@extends('layouts.admin')
@section('titulo', 'Reservas')

@section('conteudo')

<div class="page-header">
    <div>
        <h1>Reservas</h1>
        <p>Gerencie e aprove as solicitações de reserva</p>
    </div>
    <a href="{{ route('admin.reservas.create') }}" class="btn btn-primary">+ Nova Reserva</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Professor</th>
                    <th>Sala</th>
                    <th>Equipamento</th>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Finalidade</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservas as $reserva)
                <tr>
                    <td class="fw-600">{{ $reserva->professor->name ?? '—' }}</td>
                    <td class="text-muted-custom">{{ $reserva->sala->nome ?? '—' }}</td>
                    <td class="text-muted-custom">{{ $reserva->equipamento->nome ?? '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($reserva->data)->format('d/m/Y') }}</td>
                    <td class="text-muted-custom">
                        {{ substr($reserva->horario_inicio, 0, 5) }} — {{ substr($reserva->horario_fim, 0, 5) }}
                    </td>
                    <td class="text-muted-custom">{{ $reserva->finalidade ?? '—' }}</td>
                    <td>
                        @if($reserva->status === 'aprovada')
                            <span class="badge-custom badge-success">✓ Aprovada</span>
                        @elseif($reserva->status === 'pendente')
                            <span class="badge-custom badge-warning">⏳ Pendente</span>
                        @else
                            <span class="badge-custom badge-danger">✗ Negada</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:6px; flex-wrap:wrap;">
                            @if($reserva->status === 'pendente')
                                <form action="{{ route('admin.reservas.aprovar', $reserva) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">✓ Aprovar</button>
                                </form>

                                <form action="{{ route('admin.reservas.negar', $reserva) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning btn-sm">✗ Negar</button>
                                </form>
                            @endif

                            <form action="{{ route('admin.reservas.destroy', $reserva) }}"
                                  method="POST"
                                  onsubmit="return confirm('Excluir esta reserva?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-icon">📅</div>
                            <p>Nenhuma reserva encontrada.</p>
                            <a href="{{ route('admin.reservas.create') }}" class="btn btn-primary" style="margin-top:10px;">
                                Criar primeira reserva
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reservas->hasPages())
    <div style="padding: 16px 22px; border-top: 1px solid var(--border-color);">
        {{ $reservas->links() }}
    </div>
    @endif
</div>

@endsection