{{-- resources/views/admin/usuarios/index.blade.php --}}
@extends('layouts.admin')
@section('titulo', 'Usuários')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
    body { background: #0d1117; color: #e6edf3; font-family: 'DM Sans', sans-serif; }
    #main-content { background: #0d1117; padding: 2rem 2rem 3rem; }
    #topbar  { background: #161b22; border-bottom: 1px solid #21262d; color: #e6edf3; }
    #sidebar { background: #161b22; border-right: 1px solid #21262d; }
    #sidebar .sidebar-brand { border-bottom: 1px solid #21262d; }
    #sidebar .nav-link { color: rgba(230,237,243,.55); }
    #sidebar .nav-link:hover, #sidebar .nav-link.active { background: #1f6feb22; color: #58a6ff; }

    /* ── cabeçalho ── */
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.75rem; flex-wrap: wrap; gap: 1rem;
    }
    .page-header h1 {
        font-family: 'Syne', sans-serif; font-size: 1.75rem; font-weight: 800;
        color: #e6edf3; margin: 0;
    }
    .page-header h1 span { color: #58a6ff; }
    .page-header .sub { font-size: .82rem; color: #8b949e; margin-top: .25rem; }

    .btn-novo {
        display: inline-flex; align-items: center; gap: .5rem;
        background: #1f6feb; color: #fff; border: none; border-radius: 8px;
        padding: .6rem 1.1rem; font-size: .88rem; font-weight: 600;
        text-decoration: none; transition: background .2s, transform .15s;
        white-space: nowrap;
    }
    .btn-novo:hover { background: #388bfd; color: #fff; transform: translateY(-1px); }

    /* ── barra de busca ── */
    .search-bar {
        display: flex; align-items: center; gap: .75rem;
        margin-bottom: 1.25rem; flex-wrap: wrap;
    }
    .search-wrap { position: relative; flex: 1; min-width: 220px; max-width: 380px; }
    .search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #8b949e; font-size: .95rem; }
    .search-wrap input {
        width: 100%; background: #161b22; border: 1px solid #21262d; border-radius: 8px;
        color: #e6edf3; font-size: .88rem; padding: .55rem .9rem .55rem 2.3rem;
        outline: none; transition: border-color .2s;
    }
    .search-wrap input::placeholder { color: #8b949e; }
    .search-wrap input:focus { border-color: #388bfd; }

    .filter-select {
        background: #161b22; border: 1px solid #21262d; border-radius: 8px;
        color: #e6edf3; font-size: .85rem; padding: .55rem .85rem;
        outline: none; cursor: pointer; transition: border-color .2s;
    }
    .filter-select:focus { border-color: #388bfd; }

    .count-badge {
        margin-left: auto; font-size: .78rem; color: #8b949e;
        background: #161b22; border: 1px solid #21262d;
        border-radius: 6px; padding: .3rem .75rem;
    }

    /* ── tabela ── */
    .panel {
        background: #161b22; border: 1px solid #21262d; border-radius: 14px; overflow: hidden;
    }
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        font-size: .68rem; text-transform: uppercase; letter-spacing: .08em;
        color: #8b949e; padding: .75rem 1.1rem; text-align: left;
        border-bottom: 1px solid #21262d; white-space: nowrap;
        background: #161b22;
    }
    tbody td {
        padding: .85rem 1.1rem; font-size: .88rem; color: #c9d1d9;
        border-bottom: 1px solid #21262d; vertical-align: middle;
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr { transition: background .15s; }
    tbody tr:hover td { background: #1c2128; }

    /* avatar */
    .avatar {
        width: 34px; height: 34px; border-radius: 50%;
        background: #1f6feb; color: #fff;
        font-size: .78rem; font-weight: 700;
        display: inline-flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .user-cell { display: flex; align-items: center; gap: .75rem; }
    .user-name  { font-weight: 500; color: #e6edf3; }
    .user-email { font-size: .76rem; color: #8b949e; margin-top: .1rem; }

    /* badges de role */
    .role-badge {
        display: inline-flex; align-items: center; gap: .3rem;
        font-size: .7rem; font-weight: 700; padding: .2rem .6rem;
        border-radius: 20px; text-transform: uppercase; letter-spacing: .05em;
        white-space: nowrap;
    }
    .role-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .role-badge.admin     { background: #58a6ff22; color: #58a6ff; }
    .role-badge.professor { background: #bc8cff22; color: #bc8cff; }
    .role-badge.aluno     { background: #3fb95022; color: #3fb950; }

    /* ações */
    .actions { display: flex; align-items: center; gap: .4rem; }
    .btn-action {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px; border-radius: 7px; border: none;
        font-size: .9rem; cursor: pointer; text-decoration: none;
        transition: background .15s, color .15s;
    }
    .btn-edit   { background: #1f6feb22; color: #58a6ff; }
    .btn-edit:hover   { background: #1f6feb44; color: #88c0fd; }
    .btn-delete { background: #f8514922; color: #f85149; }
    .btn-delete:hover { background: #f8514944; color: #ff7b72; }

    /* estado vazio */
    .empty-state {
        text-align: center; padding: 3.5rem 1rem; color: #8b949e;
    }
    .empty-state i { font-size: 2.5rem; display: block; margin-bottom: .75rem; color: #21262d; }
    .empty-state p { font-size: .9rem; }

    /* paginação */
    .pagination-wrap {
        display: flex; align-items: center; justify-content: space-between;
        padding: .9rem 1.1rem; border-top: 1px solid #21262d;
        flex-wrap: wrap; gap: .5rem;
    }
    .pagination-wrap .info { font-size: .78rem; color: #8b949e; }
    .pagination-wrap .pagination { margin: 0; }
    .page-item .page-link {
        background: #0d1117; border-color: #21262d; color: #8b949e;
        font-size: .82rem; padding: .35rem .65rem; border-radius: 6px;
    }
    .page-item.active .page-link { background: #1f6feb; border-color: #1f6feb; color: #fff; }
    .page-item .page-link:hover  { background: #1c2128; color: #e6edf3; }
    .page-item.disabled .page-link { opacity: .4; }
</style>
@endpush

@section('conteudo')

{{-- ── CABEÇALHO ── --}}
<div class="page-header">
    <div>
        <h1>Usuários <span>({{ $usuarios->total() }})</span></h1>
        <p class="sub">Gerencie todos os usuários cadastrados no sistema.</p>
    </div>
    <a href="{{ route('admin.usuarios.create') }}" class="btn-novo">
        <i class="bi bi-person-plus-fill"></i> Novo usuário
    </a>
</div>

{{-- ── BUSCA E FILTRO ── --}}
<div class="search-bar">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="buscaInput" placeholder="Buscar por nome ou e-mail..." oninput="filtrar()">
    </div>
    <select class="filter-select" id="filtroPerfil" onchange="filtrar()">
        <option value="">Todos os perfis</option>
        <option value="admin">Administrador</option>
        <option value="professor">Professor</option>
        <option value="aluno">Aluno</option>
    </select>
    <span class="count-badge" id="contagem">{{ $usuarios->count() }} exibidos</span>
</div>

{{-- ── TABELA ── --}}
<div class="panel">
    <div class="table-wrap">
        <table id="tabelaUsuarios">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Perfil</th>
                    <th>Cadastrado em</th>
                    <th style="text-align:right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $u)
                <tr data-nome="{{ strtolower($u->name) }}"
                    data-email="{{ strtolower($u->email) }}"
                    data-role="{{ $u->role }}">

                    <td>
                        <div class="user-cell">
                            <div class="avatar">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                            <div>
                                <div class="user-name">{{ $u->name }}</div>
                                <div class="user-email">{{ $u->email }}</div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span class="role-badge {{ $u->role }}">
                            @if($u->role === 'admin') Administrador
                            @elseif($u->role === 'professor') Professor
                            @else Aluno
                            @endif
                        </span>
                    </td>

                    <td style="color:#8b949e;font-size:.82rem">
                        {{ $u->created_at->format('d/m/Y') }}
                    </td>

                    <td>
                        <div class="actions" style="justify-content:flex-end">
                            <a href="{{ route('admin.usuarios.edit', $u->id) }}"
                               class="btn-action btn-edit" title="Editar">
                                <i class="bi bi-pencil-fill"></i>
                            </a>

                            <form action="{{ route('admin.usuarios.destroy', $u->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Remover {{ addslashes($u->name) }}? Esta ação não pode ser desfeita.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Remover">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <i class="bi bi-people"></i>
                            <p>Nenhum usuário cadastrado ainda.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- paginação --}}
    @if($usuarios->hasPages())
    <div class="pagination-wrap">
        <span class="info">
            Mostrando {{ $usuarios->firstItem() }}–{{ $usuarios->lastItem() }}
            de {{ $usuarios->total() }} usuários
        </span>
        {{ $usuarios->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
    function filtrar() {
        const busca  = document.getElementById('buscaInput').value.toLowerCase();
        const perfil = document.getElementById('filtroPerfil').value;
        const linhas = document.querySelectorAll('#tabelaUsuarios tbody tr[data-nome]');
        let visiveis = 0;

        linhas.forEach(tr => {
            const nome  = tr.dataset.nome  || '';
            const email = tr.dataset.email || '';
            const role  = tr.dataset.role  || '';

            const matchBusca  = !busca  || nome.includes(busca) || email.includes(busca);
            const matchPerfil = !perfil || role === perfil;

            if (matchBusca && matchPerfil) {
                tr.style.display = '';
                visiveis++;
            } else {
                tr.style.display = 'none';
            }
        });

        document.getElementById('contagem').textContent = visiveis + ' exibidos';
    }
</script>
@endpush