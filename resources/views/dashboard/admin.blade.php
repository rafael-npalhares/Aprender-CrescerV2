{{-- resources/views/dashboard/admin.blade.php --}}
@extends('layouts.admin')
@section('titulo', 'Dashboard')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
    * { box-sizing: border-box; }

    body {
        font-family: 'DM Sans', sans-serif;
        background: #0d1117;
        color: #e6edf3;
    }

    /* ── override do layout pai ── */
    #main-content { background: #0d1117; padding: 2rem 2rem 3rem; }
    #topbar {
        background: #161b22;
        border-bottom: 1px solid #21262d;
        color: #e6edf3;
    }
    #sidebar { background: #161b22; border-right: 1px solid #21262d; }
    #sidebar .sidebar-brand { border-bottom: 1px solid #21262d; }
    #sidebar .nav-link { color: rgba(230,237,243,.55); }
    #sidebar .nav-link:hover, #sidebar .nav-link.active { background: #1f6feb22; color: #58a6ff; }

    /* ── cabeçalho da página ── */
    .dash-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 2rem;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .dash-header h1 {
        font-family: 'Syne', sans-serif;
        font-size: 2rem;
        font-weight: 800;
        color: #e6edf3;
        margin: 0;
        line-height: 1;
    }
    .dash-header h1 span { color: #58a6ff; }
    .dash-header .sub {
        font-size: .85rem;
        color: #8b949e;
        margin-top: .3rem;
    }
    .dash-date {
        font-size: .82rem;
        color: #8b949e;
        background: #161b22;
        border: 1px solid #21262d;
        border-radius: 8px;
        padding: .4rem .9rem;
    }

    /* ── grade de stat cards ── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media(max-width:1100px){ .stat-grid { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:600px){ .stat-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: #161b22;
        border: 1px solid #21262d;
        border-radius: 14px;
        padding: 1.4rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: .5rem;
        position: relative;
        overflow: hidden;
        transition: border-color .2s, transform .2s;
        cursor: default;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        background: var(--accent);
        opacity: .7;
        transition: opacity .2s;
    }
    .stat-card:hover { border-color: var(--accent); transform: translateY(-2px); }
    .stat-card:hover::before { opacity: 1; }

    .stat-card .icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem;
        background: color-mix(in srgb, var(--accent) 15%, transparent);
        color: var(--accent);
        margin-bottom: .2rem;
    }
    .stat-card .value {
        font-family: 'Syne', sans-serif;
        font-size: 2rem;
        font-weight: 800;
        color: #e6edf3;
        line-height: 1;
    }
    .stat-card .label {
        font-size: .78rem;
        color: #8b949e;
        text-transform: uppercase;
        letter-spacing: .06em;
    }
    .stat-card .trend {
        font-size: .75rem;
        margin-top: auto;
        display: flex;
        align-items: center;
        gap: .3rem;
        color: #8b949e;
    }
    .stat-card .trend.up   { color: #3fb950; }
    .stat-card .trend.warn { color: #d29922; }
    .stat-card .trend.down { color: #f85149; }

    /* ── linha central ── */
    .mid-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    @media(max-width:1000px){ .mid-grid { grid-template-columns: 1fr; } }

    /* ── painéis genéricos ── */
    .panel {
        background: #161b22;
        border: 1px solid #21262d;
        border-radius: 14px;
        overflow: hidden;
    }
    .panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.1rem 1.4rem;
        border-bottom: 1px solid #21262d;
    }
    .panel-head h2 {
        font-family: 'Syne', sans-serif;
        font-size: .95rem;
        font-weight: 700;
        color: #e6edf3;
        margin: 0;
        display: flex; align-items: center; gap: .5rem;
    }
    .panel-head h2 i { color: #58a6ff; }
    .panel-head a {
        font-size: .78rem;
        color: #58a6ff;
        text-decoration: none;
        opacity: .8;
        transition: opacity .15s;
    }
    .panel-head a:hover { opacity: 1; }
    .panel-body { padding: 1.2rem 1.4rem; }

    /* ── tabela de reservas ── */
    .res-table { width: 100%; border-collapse: collapse; }
    .res-table th {
        font-size: .7rem;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: #8b949e;
        padding: .5rem .8rem;
        text-align: left;
        border-bottom: 1px solid #21262d;
    }
    .res-table td {
        padding: .8rem .8rem;
        font-size: .86rem;
        color: #c9d1d9;
        border-bottom: 1px solid #21262d08;
        vertical-align: middle;
    }
    .res-table tr:last-child td { border-bottom: none; }
    .res-table tr:hover td { background: #1f262e; }

    .badge-status {
        display: inline-flex; align-items: center; gap: .35rem;
        font-size: .72rem; font-weight: 600;
        padding: .2rem .65rem;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .badge-status.pendente  { background: #d2992222; color: #d29922; }
    .badge-status.aprovada  { background: #3fb95022; color: #3fb950; }
    .badge-status.negada    { background: #f8514922; color: #f85149; }
    .badge-status::before {
        content: '';
        width: 6px; height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .avatar-sm {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: #1f6feb;
        color: #fff;
        font-size: .7rem;
        font-weight: 700;
        display: inline-flex; align-items: center; justify-content: center;
        margin-right: .4rem;
    }

    /* ── avisos ── */
    .aviso-item {
        display: flex;
        align-items: flex-start;
        gap: .9rem;
        padding: .9rem 0;
        border-bottom: 1px solid #21262d;
    }
    .aviso-item:last-child { border-bottom: none; padding-bottom: 0; }
    .aviso-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: #58a6ff;
        margin-top: .4rem;
        flex-shrink: 0;
    }
    .aviso-titulo { font-size: .88rem; font-weight: 500; color: #e6edf3; }
    .aviso-meta   { font-size: .74rem; color: #8b949e; margin-top: .2rem; }
    .aviso-badge  {
        margin-left: auto; flex-shrink: 0;
        font-size: .65rem; font-weight: 600;
        padding: .15rem .5rem;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .aviso-badge.todos      { background: #1f6feb22; color: #58a6ff; }
    .aviso-badge.alunos     { background: #3fb95022; color: #3fb950; }
    .aviso-badge.professores{ background: #bc8cff22; color: #bc8cff; }

    /* ── linha inferior ── */
    .bot-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    @media(max-width:800px){ .bot-grid { grid-template-columns: 1fr; } }

    /* ── ações rápidas ── */
    .quick-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .75rem;
    }
    .quick-btn {
        display: flex; align-items: center; gap: .75rem;
        background: #0d1117;
        border: 1px solid #21262d;
        border-radius: 10px;
        padding: .9rem 1rem;
        text-decoration: none;
        color: #c9d1d9;
        font-size: .85rem;
        font-weight: 500;
        transition: border-color .2s, background .2s, color .2s;
    }
    .quick-btn i {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        background: color-mix(in srgb, var(--accent) 15%, transparent);
        color: var(--accent);
        flex-shrink: 0;
    }
    .quick-btn:hover {
        border-color: var(--accent);
        background: color-mix(in srgb, var(--accent) 6%, #0d1117);
        color: #e6edf3;
    }

    /* ── mini progress bar ── */
    .progress-list { display: flex; flex-direction: column; gap: .9rem; }
    .prog-item {}
    .prog-header { display: flex; justify-content: space-between; font-size: .8rem; margin-bottom: .35rem; }
    .prog-label  { color: #c9d1d9; }
    .prog-value  { color: #8b949e; }
    .prog-track  {
        height: 5px; border-radius: 99px;
        background: #21262d;
        overflow: hidden;
    }
    .prog-fill {
        height: 100%; border-radius: 99px;
        background: var(--accent);
        transition: width .6s cubic-bezier(.4,0,.2,1);
    }

    /* ── animações ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .stat-card  { animation: fadeUp .4s ease both; }
    .stat-card:nth-child(1){ animation-delay:.05s }
    .stat-card:nth-child(2){ animation-delay:.10s }
    .stat-card:nth-child(3){ animation-delay:.15s }
    .stat-card:nth-child(4){ animation-delay:.20s }
    .stat-card:nth-child(5){ animation-delay:.25s }
    .stat-card:nth-child(6){ animation-delay:.30s }
    .stat-card:nth-child(7){ animation-delay:.35s }
    .panel { animation: fadeUp .5s ease .2s both; }
</style>
@endpush

@section('conteudo')

{{-- ── CABEÇALHO ── --}}
<div class="dash-header">
    <div>
        <h1>Olá, <span>{{ explode(' ', auth()->user()->name)[0] }}</span> 👋</h1>
        <p class="sub">Aqui está um resumo do sistema hoje.</p>
    </div>
    <div class="dash-date">
        <i class="bi bi-calendar3 me-1"></i>
        {{ now()->translatedFormat('l, d \d\e F \d\e Y') }}
    </div>
</div>

{{-- ── STAT CARDS — linha 1 ── --}}
<div class="stat-grid">

    <div class="stat-card" style="--accent:#58a6ff">
        <div class="icon"><i class="bi bi-people-fill"></i></div>
        <div class="value">{{ $totalUsuarios }}</div>
        <div class="label">Total de Usuários</div>
        <div class="trend up"><i class="bi bi-arrow-up-short"></i> sistema ativo</div>
    </div>

    <div class="stat-card" style="--accent:#3fb950">
        <div class="icon"><i class="bi bi-mortarboard-fill"></i></div>
        <div class="value">{{ $totalAlunos }}</div>
        <div class="label">Alunos</div>
        <div class="trend"><i class="bi bi-dash"></i> matriculados</div>
    </div>

    <div class="stat-card" style="--accent:#bc8cff">
        <div class="icon"><i class="bi bi-person-badge-fill"></i></div>
        <div class="value">{{ $totalProfessores }}</div>
        <div class="label">Professores</div>
        <div class="trend"><i class="bi bi-dash"></i> ativos</div>
    </div>

    <div class="stat-card" style="--accent:#ffa657">
        <div class="icon"><i class="bi bi-collection-fill"></i></div>
        <div class="value">{{ $totalTurmas }}</div>
        <div class="label">Turmas Ativas</div>
        <div class="trend"><i class="bi bi-dash"></i> em andamento</div>
    </div>

</div>

{{-- ── STAT CARDS — linha 2 ── --}}
<div class="stat-grid" style="margin-bottom:1.5rem">

    <div class="stat-card" style="--accent:#f85149">
        <div class="icon"><i class="bi bi-megaphone-fill"></i></div>
        <div class="value">{{ $totalAvisosAtivos }}</div>
        <div class="label">Avisos Ativos</div>
        <div class="trend warn"><i class="bi bi-dot"></i> publicados</div>
    </div>

    <div class="stat-card" style="--accent:#d29922">
        <div class="icon"><i class="bi bi-calendar-check-fill"></i></div>
        <div class="value">{{ $totalReservasPendentes }}</div>
        <div class="label">Reservas Pendentes</div>
        @if($totalReservasPendentes > 0)
            <div class="trend warn"><i class="bi bi-exclamation-circle"></i> requer atenção</div>
        @else
            <div class="trend up"><i class="bi bi-check-circle"></i> tudo em dia</div>
        @endif
    </div>

    <div class="stat-card" style="--accent:#39d353">
        <div class="icon"><i class="bi bi-book-fill"></i></div>
        <div class="value">{{ $totalEmprestimos }}</div>
        <div class="label">Empréstimos Ativos</div>
        <div class="trend"><i class="bi bi-dash"></i> em aberto</div>
    </div>

    <div class="stat-card" style="--accent:#58a6ff">
        <div class="icon"><i class="bi bi-graph-up-arrow"></i></div>
        <div class="value">
            @php
                $total = $totalAlunos + $totalProfessores;
                $pct = $totalUsuarios > 0 ? round($total / $totalUsuarios * 100) : 0;
            @endphp
            {{ $pct }}%
        </div>
        <div class="label">Usuários com Perfil</div>
        <div class="trend up"><i class="bi bi-arrow-up-short"></i> alunos + professores</div>
    </div>

</div>

{{-- ── LINHA CENTRAL: tabela + avisos ── --}}
<div class="mid-grid">

    {{-- tabela de reservas --}}
    <div class="panel">
        <div class="panel-head">
            <h2><i class="bi bi-calendar-check-fill"></i> Últimas Reservas</h2>
            <a href="{{ route('admin.reservas.index') }}">Ver todas →</a>
        </div>
        <div style="overflow-x:auto">
            <table class="res-table">
                <thead>
                    <tr>
                        <th>Professor</th>
                        <th>Recurso</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ultimasReservas as $r)
                    <tr>
                        <td>
                            <span class="avatar-sm">{{ strtoupper(substr($r->professor->name ?? 'A', 0, 1)) }}</span>
                            {{ $r->professor->name ?? '—' }}
                        </td>
                        <td>
                            @if($r->sala)
                                <i class="bi bi-door-open text-info me-1"></i>{{ $r->sala->nome }}
                            @elseif($r->equipamento)
                                <i class="bi bi-cpu text-warning me-1"></i>{{ $r->equipamento->nome }}
                            @else
                                <span style="color:#8b949e">—</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($r->data)->format('d/m/Y') }}</td>
                        <td style="color:#8b949e;font-size:.8rem">
                            {{ substr($r->horario_inicio,0,5) }} – {{ substr($r->horario_fim,0,5) }}
                        </td>
                        <td>
                            <span class="badge-status {{ $r->status }}">{{ ucfirst($r->status) }}</span>
                        </td>
                        <td>
                            @if($r->status === 'pendente')
                                <div class="d-flex gap-1">
                                    <form action="{{ route('admin.reservas.aprovar', $r->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm" style="background:#3fb95022;color:#3fb950;border:none;border-radius:6px;padding:.2rem .55rem;font-size:.75rem;" title="Aprovar">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reservas.negar', $r->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm" style="background:#f8514922;color:#f85149;border:none;border-radius:6px;padding:.2rem .55rem;font-size:.75rem;" title="Negar">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;color:#8b949e;padding:2rem;">
                            <i class="bi bi-calendar-x" style="font-size:1.5rem;display:block;margin-bottom:.5rem;"></i>
                            Nenhuma reserva encontrada
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- avisos recentes --}}
    <div class="panel">
        <div class="panel-head">
            <h2><i class="bi bi-megaphone-fill"></i> Últimos Avisos</h2>
            <a href="{{ route('admin.avisos.index') }}">Ver todos →</a>
        </div>
        <div class="panel-body">
            @forelse($ultimosAvisos as $av)
            <div class="aviso-item">
                <div class="aviso-dot"></div>
                <div style="flex:1;min-width:0">
                    <div class="aviso-titulo">{{ $av->titulo }}</div>
                    <div class="aviso-meta">
                        <i class="bi bi-calendar3"></i>
                        {{ $av->created_at->format('d/m/Y') }}
                        &nbsp;·&nbsp;
                        <i class="bi bi-person"></i>
                        {{ $av->autor->name ?? 'Admin' }}
                    </div>
                </div>
                <span class="aviso-badge {{ $av->visivel_para }}">
                    {{ $av->visivel_para === 'todos' ? 'Todos' : ($av->visivel_para === 'alunos' ? 'Alunos' : 'Professores') }}
                </span>
            </div>
            @empty
            <div style="text-align:center;color:#8b949e;padding:1.5rem 0;">
                <i class="bi bi-megaphone" style="font-size:1.5rem;display:block;margin-bottom:.5rem;"></i>
                Nenhum aviso publicado
            </div>
            @endforelse

            <a href="{{ route('admin.avisos.create') }}"
               style="display:flex;align-items:center;justify-content:center;gap:.4rem;
                      margin-top:1rem;padding:.65rem;border-radius:8px;
                      background:#1f6feb18;border:1px dashed #1f6feb55;
                      color:#58a6ff;text-decoration:none;font-size:.82rem;
                      transition:background .2s;"
               onmouseover="this.style.background='#1f6feb28'"
               onmouseout="this.style.background='#1f6feb18'">
                <i class="bi bi-plus-lg"></i> Novo aviso
            </a>
        </div>
    </div>

</div>

{{-- ── LINHA INFERIOR: ações rápidas + ocupação ── --}}
<div class="bot-grid">

    {{-- ações rápidas --}}
    <div class="panel">
        <div class="panel-head">
            <h2><i class="bi bi-lightning-charge-fill"></i> Ações Rápidas</h2>
        </div>
        <div class="panel-body">
            <div class="quick-grid">
                <a href="{{ route('admin.usuarios.create') }}" class="quick-btn" style="--accent:#58a6ff">
                    <i class="bi bi-person-plus-fill"></i> Novo Usuário
                </a>
                <a href="{{ route('admin.avisos.create') }}" class="quick-btn" style="--accent:#f85149">
                    <i class="bi bi-megaphone-fill"></i> Novo Aviso
                </a>
                <a href="{{ route('admin.turmas.create') }}" class="quick-btn" style="--accent:#ffa657">
                    <i class="bi bi-collection-fill"></i> Nova Turma
                </a>
                <a href="{{ route('admin.grade.create') }}" class="quick-btn" style="--accent:#bc8cff">
                    <i class="bi bi-grid-3x3-gap-fill"></i> Novo Horário
                </a>
                <a href="{{ route('admin.biblioteca.livros.create') }}" class="quick-btn" style="--accent:#39d353">
                    <i class="bi bi-book-fill"></i> Novo Livro
                </a>
                <a href="{{ route('admin.cantina.produtos.create') }}" class="quick-btn" style="--accent:#d29922">
                    <i class="bi bi-bag-fill"></i> Novo Produto
                </a>
            </div>
        </div>
    </div>

    {{-- ocupação do sistema --}}
    <div class="panel">
        <div class="panel-head">
            <h2><i class="bi bi-bar-chart-fill"></i> Ocupação do Sistema</h2>
        </div>
        <div class="panel-body">
            <div class="progress-list">
                @php
                    $items = [
                        ['label' => 'Alunos cadastrados',      'val' => $totalAlunos,            'max' => max($totalUsuarios,1), 'accent' => '#3fb950'],
                        ['label' => 'Professores cadastrados', 'val' => $totalProfessores,        'max' => max($totalUsuarios,1), 'accent' => '#bc8cff'],
                        ['label' => 'Avisos publicados',       'val' => $totalAvisosAtivos,       'max' => max($totalAvisosAtivos+5,1), 'accent' => '#f85149'],
                        ['label' => 'Reservas pendentes',      'val' => $totalReservasPendentes,  'max' => max($totalReservasPendentes+5,1), 'accent' => '#d29922'],
                        ['label' => 'Empréstimos em aberto',   'val' => $totalEmprestimos,        'max' => max($totalEmprestimos+5,1), 'accent' => '#58a6ff'],
                    ];
                @endphp
                @foreach($items as $item)
                @php $pct = round($item['val'] / $item['max'] * 100); @endphp
                <div class="prog-item">
                    <div class="prog-header">
                        <span class="prog-label">{{ $item['label'] }}</span>
                        <span class="prog-value">{{ $item['val'] }}</span>
                    </div>
                    <div class="prog-track">
                        <div class="prog-fill" style="width:{{ $pct }}%;background:{{ $item['accent'] }}"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

@endsection