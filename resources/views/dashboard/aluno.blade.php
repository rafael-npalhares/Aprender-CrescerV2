@extends('layouts.app')

@section('titulo', 'Dashboard')

@section('conteudo')

<div class="page-header">
    <div>
        <h1>Olá, {{ auth()->user()->name ?? 'Aluno' }} 🎒</h1>
        <p>Veja seus avisos, horários e empréstimos.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-md-4">
        <div class="metric-card">
            <div class="metric-icon yellow">🔔</div>
            <div>
                <div class="metric-value">{{ isset($avisos) ? $avisos->count() : 0 }}</div>
                <div class="metric-label">Avisos</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="metric-card">
            <div class="metric-icon blue">📚</div>
            <div>
                <div class="metric-value">{{ isset($meusEmprestimos) ? $meusEmprestimos->count() : 0 }}</div>
                <div class="metric-label">Livros Emprestados</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="metric-card">
            <div class="metric-icon green">📋</div>
            <div>
                <div class="metric-value">{{ isset($meuHorario) ? count($meuHorario) : 0 }}</div>
                <div class="metric-label">Aulas Hoje</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- AVISOS --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header-custom">
                <span class="card-title-custom">Avisos</span>
                <a href="{{ route('aluno.avisos') }}" class="btn btn-outline btn-sm">Ver todos</a>
            </div>
            <div style="padding:8px 0;">
                @forelse($avisos ?? [] as $aviso)
                <div style="padding:14px 22px; border-bottom:1px solid var(--border);">
                    <div style="font-weight:600; font-size:13.5px; margin-bottom:4px;">{{ $aviso->titulo }}</div>
                    <div style="font-size:12.5px; color:var(--text-muted); overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;">
                        {{ $aviso->conteudo }}
                    </div>
                    <div style="font-size:11.5px; color:var(--text-muted); margin-top:6px;">
                        {{ \Carbon\Carbon::parse($aviso->created_at)->format('d/m/Y') }}
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon">🔔</div>
                    <p>Nenhum aviso no momento.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- MEUS EMPRÉSTIMOS --}}
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header-custom">
                <span class="card-title-custom">Meus Empréstimos</span>
                <a href="{{ route('biblioteca.emprestimos') }}" class="btn btn-outline btn-sm">Ver todos</a>
            </div>
            <div style="padding:8px 0;">
                @forelse($meusEmprestimos ?? [] as $emp)
                <div style="padding:13px 22px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:12px;">
                    <div style="font-size:22px;">📖</div>
                    <div>
                        <div style="font-weight:600; font-size:13px;">{{ $emp->livro->titulo ?? '—' }}</div>
                        <div style="font-size:12px; color:var(--text-muted);">
                            Devolução: {{ \Carbon\Carbon::parse($emp->data_devolucao)->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon">📚</div>
                    <p>Nenhum livro emprestado.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

@endsection