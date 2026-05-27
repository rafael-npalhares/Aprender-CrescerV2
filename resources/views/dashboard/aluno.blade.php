{{-- resources/views/dashboard/aluno.blade.php --}}
@extends('layouts.app')
@section('titulo', 'Dashboard — Aluno')

@section('conteudo')
@include('componentes.alerta')

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background:#2d6ef71a;">
                    <i class="bi bi-megaphone-fill" style="color:#2d6ef7;font-size:1.3rem;"></i>
                </div>
                <div>
                    <div class="fw-bold fs-4" style="color:#1a2238;">{{ $avisos->count() }}</div>
                    <div style="font-size:.8rem;color:#8899bb;">Avisos</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background:#22c55e1a;">
                    <i class="bi bi-book-fill" style="color:#22c55e;font-size:1.3rem;"></i>
                </div>
                <div>
                    <div class="fw-bold fs-4" style="color:#1a2238;">{{ $meusEmprestimos->count() }}</div>
                    <div style="font-size:.8rem;color:#8899bb;">Empréstimos</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white py-3" style="border-bottom:1px solid #e8eaf0;">
                <span class="fw-semibold" style="color:#1a2238;">Avisos</span>
            </div>
            <div class="card-body">
                @forelse($avisos as $aviso)
                    @include('componentes.card-aviso', ['aviso' => $aviso])
                @empty
                    <p class="text-muted text-center mt-2">Nenhum aviso.</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white py-3" style="border-bottom:1px solid #e8eaf0;">
                <span class="fw-semibold" style="color:#1a2238;">Meu Horário</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Dia</th><th>Hora</th><th>Disciplina</th></tr></thead>
                    <tbody>
                        @forelse($meuHorario as $h)
                            <tr>
                                <td>{{ $h->dia_semana }}</td>
                                <td>{{ $h->horario_inicio }} – {{ $h->horario_fim }}</td>
                                <td>{{ $h->disciplina }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">Sem horários cadastrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection