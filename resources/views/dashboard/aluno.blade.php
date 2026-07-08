{{-- resources/views/dashboard/aluno.blade.php --}}
@extends('layouts.admin')
@section('titulo', 'Meu Perfil')

@push('styles')
<style>
    .perfil-card {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 16px; padding: 2rem; margin-bottom: 1.75rem;
        display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;
    }
    .perfil-avatar {
        width: 72px; height: 72px; border-radius: 50%;
        background: var(--blue-primary); color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; font-weight: 700; flex-shrink: 0;
    }
    .perfil-info h2 {
        font-size: 1.3rem; font-weight: 700; color: var(--text-main); margin: 0 0 .5rem;
    }
    .perfil-meta {
        display: flex; gap: 1.75rem; flex-wrap: wrap;
    }
    .perfil-meta-item { display: flex; flex-direction: column; gap: .15rem; }
    .perfil-meta-item .label {
        font-size: .7rem; text-transform: uppercase; letter-spacing: .06em;
        color: var(--text-secondary);
    }
    .perfil-meta-item .value {
        font-size: .92rem; font-weight: 600; color: var(--text-main);
    }

    .stats-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.25rem; margin-bottom: 1.75rem;
    }
    .stat-card {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 14px; padding: 1.25rem 1.5rem;
        display: flex; align-items: center; gap: 1rem;
    }
    .stat-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;
    }
    .stat-icon.blue   { background: var(--badge-blue-bg);  color: var(--badge-blue);  }
    .stat-icon.green  { background: var(--badge-green-bg); color: var(--badge-green); }
    .stat-icon.yellow { background: var(--badge-yellow-bg);color: var(--badge-yellow);}
    .stat-value { font-size: 1.4rem; font-weight: 700; color: var(--text-main); line-height: 1; }
    .stat-label { font-size: .8rem; color: var(--text-secondary); margin-top: .25rem; }

    .section-title {
        font-size: 1.05rem; font-weight: 700; color: var(--text-main);
        margin: 0 0 1rem; display: flex; align-items: center; gap: .5rem;
    }

    .aviso-item {
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-left: 3px solid var(--blue-primary);
        border-radius: 10px; padding: 1rem 1.25rem; margin-bottom: .85rem;
    }
    .aviso-item h4 { font-size: .92rem; font-weight: 700; color: var(--text-main); margin: 0 0 .35rem; }
    .aviso-item p  { font-size: .82rem; color: var(--text-secondary); margin: 0; line-height: 1.5; }
    .aviso-item .data { font-size: .72rem; color: var(--text-secondary); margin-top: .5rem; display: block; }

    .emprestimo-item {
        display: flex; align-items: center; justify-content: space-between;
        background: var(--card-bg); border: 1px solid var(--border-color);
        border-radius: 10px; padding: .9rem 1.25rem; margin-bottom: .75rem;
    }
    .emprestimo-item .titulo { font-weight: 600; font-size: .88rem; color: var(--text-main); }
    .emprestimo-item .autor  { font-size: .78rem; color: var(--text-secondary); }

    #modalAvisos .modal-header { border-bottom: 1px solid var(--border-color); }
    #modalAvisos .aviso-modal-item {
        border-left: 3px solid var(--blue-primary);
        background: var(--hover-bg); border-radius: 10px;
        padding: 1rem 1.25rem; margin-bottom: .85rem;
    }
    #modalAvisos .aviso-modal-item:last-child { margin-bottom: 0; }
    #modalAvisos .aviso-modal-item h5 { font-size: .95rem; font-weight: 700; color: var(--text-main); margin: 0 0 .4rem; }
    #modalAvisos .aviso-modal-item p  { font-size: .85rem; color: var(--text-secondary); margin: 0; line-height: 1.55; }
</style>
@endpush

@section('conteudo')


<div class="perfil-card">
    <div class="perfil-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
    <div class="perfil-info">
        <h2>{{ auth()->user()->name }}</h2>
        <div class="perfil-meta">
            <div class="perfil-meta-item">
                <span class="label">Turma</span>
                <span class="value">
                    @if($aluno && $aluno->turma)
                        {{ $aluno->turma->serie }}º ano {{ $aluno->turma->turma }} — {{ ucfirst($aluno->turma->turno) }}
                    @else
                        Não atribuída
                    @endif
                </span>
            </div>
            <div class="perfil-meta-item">
                <span class="label">Matrícula</span>
                <span class="value">{{ $aluno->matricula ?? '—' }}</span>
            </div>
            <div class="perfil-meta-item">
                <span class="label">E-mail</span>
                <span class="value">{{ auth()->user()->email }}</span>
            </div>
        </div>
    </div>
</div>


<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="bi bi-megaphone-fill"></i></div>
        <div>
            <div class="stat-value">{{ $avisos->count() }}</div>
            <div class="stat-label">Avisos recentes</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="bi bi-journal-bookmark-fill"></i></div>
        <div>
            <div class="stat-value">{{ $meusEmprestimos->count() }}</div>
            <div class="stat-label">Empréstimos ativos</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow"><i class="bi bi-pin-angle-fill"></i></div>
        <div>
            <div class="stat-value">{{ $avisosFixados->count() }}</div>
            <div class="stat-label">Avisos fixados</div>
        </div>
    </div>
</div>

<div style="display:grid; grid-template-columns: 1.4fr 1fr; gap:1.5rem;">

  
    <div>
        <div class="section-title"><i class="bi bi-megaphone-fill" style="color:var(--blue-primary);"></i> Avisos recentes</div>

        @forelse($avisos as $aviso)
            <div class="aviso-item">
                <h4>{{ $aviso->titulo }}</h4>
                <p>{{ \Illuminate\Support\Str::limit($aviso->conteudo, 140) }}</p>
                <span class="data">{{ $aviso->created_at->format('d/m/Y') }}</span>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-megaphone empty-icon"></i>
                <p>Nenhum aviso no momento.</p>
            </div>
        @endforelse
    </div>


    <div>
        <div class="section-title"><i class="bi bi-journal-bookmark-fill" style="color:var(--badge-green);"></i> Meus empréstimos</div>

        @forelse($meusEmprestimos as $emp)
            <div class="emprestimo-item">
                <div>
                    <div class="titulo">{{ $emp->livro->titulo ?? '—' }}</div>
                    <div class="autor">{{ $emp->livro->autor ?? '' }}</div>
                </div>
                <span class="badge-custom badge-success">Ativo</span>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-journal-x empty-icon"></i>
                <p>Nenhum empréstimo ativo.</p>
            </div>
        @endforelse

        <a href="{{ route('biblioteca.index') }}" class="btn btn-secondary" style="width:100%; text-align:center; margin-top:.5rem;">
            Ir para Biblioteca
        </a>
    </div>

</div>


@if($avisosFixados->isNotEmpty())
<div class="modal fade" id="modalAvisos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-pin-angle-fill me-2" style="color:var(--blue-primary);"></i>
                    Avisos importantes
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                @foreach($avisosFixados as $aviso)
                    <div class="aviso-modal-item">
                        <h5>{{ $aviso->titulo }}</h5>
                        <p>{{ $aviso->conteudo }}</p>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendi</button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
@if($avisosFixados->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = new bootstrap.Modal(document.getElementById('modalAvisos'));
        modal.show();
    });
</script>
@endif
@endpush