{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Aprender & Crescer')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ── VARIÁVEIS DO TEMA ESCURO ── */
        :root {
            --sidebar-bg:     #161b22;
            --blue-primary:   #1f6feb;
            --page-bg:        #0d1117;
            --card-bg:        #161b22;
            --border-color:   #21262d;
            --text-main:      #e6edf3;
            --text-secondary: #8b949e;
            --input-bg:       #0d1117;
            --hover-bg:       #1c2128;
            --badge-green-bg: #3fb95022;
            --badge-green:    #3fb950;
            --badge-blue-bg:  #58a6ff22;
            --badge-blue:     #58a6ff;
            --badge-red-bg:   #f8514922;
            --badge-red:      #f85149;
            --badge-yellow-bg:#e3b34122;
            --badge-yellow:   #e3b341;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            background: var(--page-bg);
            color: var(--text-main);
            font-family: 'DM Sans', system-ui, sans-serif;
        }

        /* ────────────────────────────────────────
           SOBRESCRITA DAS VARIÁVEIS NATIVAS DO
           BOOTSTRAP — evita "vazamento" de branco
           em tabelas, modais, dropdowns e badges
        ──────────────────────────────────────── */
        .table {
            --bs-table-bg:           transparent;
            --bs-table-striped-bg:   var(--hover-bg);
            --bs-table-hover-bg:     var(--hover-bg);
            --bs-table-active-bg:    var(--hover-bg);
            --bs-table-color:        var(--text-main);
            --bs-table-striped-color:var(--text-main);
            --bs-table-hover-color:  var(--text-main);
            --bs-table-border-color: var(--border-color);
            color: var(--text-main);
            border-color: var(--border-color);
        }

        .modal-content {
            --bs-modal-bg:           var(--card-bg);
            --bs-modal-border-color: var(--border-color);
            --bs-modal-color:        var(--text-main);
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }
        .modal-header, .modal-footer {
            border-color: var(--border-color);
        }

        .dropdown-menu {
            --bs-dropdown-bg:              var(--card-bg);
            --bs-dropdown-border-color:    var(--border-color);
            --bs-dropdown-color:           var(--text-main);
            --bs-dropdown-link-color:      var(--text-main);
            --bs-dropdown-link-hover-bg:   var(--hover-bg);
            --bs-dropdown-link-hover-color:var(--text-main);
        }

        /* ── SIDEBAR ── */
        #sidebar {
            width: 250px;
            min-height: 100vh;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
        }
        #sidebar .sidebar-brand {
            padding: 1.5rem 1.25rem;
            color: #fff;
            font-weight: 700;
            font-size: 1.05rem;
            border-bottom: 1px solid var(--border-color);
        }
        #sidebar .nav-link {
            color: rgba(230,237,243,.55);
            padding: .6rem 1.25rem;
            border-radius: 6px;
            margin: 2px 10px;
            font-size: .9rem;
            display: flex;
            align-items: center;
            gap: .6rem;
            transition: background .2s, color .2s;
            text-decoration: none;
        }
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background: #1f6feb22;
            color: #58a6ff;
        }
        #sidebar .sidebar-section {
            font-size: .7rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: .65rem 1.25rem .3rem;
            margin-top: .5rem;
        }
        #sidebar .sidebar-footer {
            margin-top: auto;
            padding: 1rem;
            border-top: 1px solid var(--border-color);
        }

        /* ── TOPBAR ── */
        #topbar {
            margin-left: 250px;
            height: 60px;
            background: var(--sidebar-bg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 99;
            justify-content: space-between;
        }
        #topbar .page-title {
            font-weight: 600;
            color: var(--text-main);
            font-size: .95rem;
        }

        /* ── MAIN ── */
        #main-content {
            margin-left: 250px;
            padding: 1.75rem;
            min-height: calc(100vh - 60px);
        }

        /* ── CARDS ── */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-main);
        }

        /* ── TABELA ── */
        .table thead th {
            font-size: .75rem;
            text-transform: uppercase;
            color: var(--text-secondary);
            letter-spacing: .06em;
            border-color: var(--border-color);
            background: var(--sidebar-bg);
            padding: .75rem 1rem;
        }
        .table tbody td {
            border-color: var(--border-color);
            vertical-align: middle;
            padding: .85rem 1rem;
        }
        .table tbody tr:hover td { background: var(--hover-bg); }
        .table-responsive { border-radius: 12px; overflow: hidden; }

        /* ── FORMULÁRIOS ── */
        .form-control,
        .form-select,
        textarea.form-control {
            background: var(--input-bg);
            border: 1.5px solid var(--border-color);
            color: var(--text-main);
            border-radius: 8px;
        }
        .form-control::placeholder { color: #3d4f6e; }
        .form-control:focus,
        .form-select:focus {
            background: var(--input-bg);
            border-color: var(--blue-primary);
            color: var(--text-main);
            box-shadow: 0 0 0 3px rgba(31,111,235,.2);
        }
        .form-control.is-invalid,
        .form-select.is-invalid { border-color: var(--badge-red); }
        .invalid-feedback { color: var(--badge-red); font-size: .8rem; }
        .form-label {
            font-size: .8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--text-secondary);
            margin-bottom: .4rem;
        }
        .form-group { margin-bottom: 1.1rem; }
        .form-check-input {
            background-color: var(--input-bg);
            border-color: var(--border-color);
        }
        .form-check-input:checked {
            background-color: var(--blue-primary);
            border-color: var(--blue-primary);
        }

        /* ── BOTÕES ── */
        .btn-primary {
            background: var(--blue-primary);
            border-color: var(--blue-primary);
            color: #fff; font-weight: 600; border-radius: 8px;
        }
        .btn-primary:hover { background: #388bfd; border-color: #388bfd; color: #fff; }

        .btn-secondary {
            background: var(--hover-bg);
            border-color: var(--border-color);
            color: var(--text-main); font-weight: 600; border-radius: 8px;
        }
        .btn-secondary:hover { background: #2d333b; color: var(--text-main); border-color: var(--border-color); }

        .btn-success  { background: #238636; border-color: #238636; color: #fff; border-radius: 8px; }
        .btn-success:hover { background: #2ea043; color: #fff; }

        .btn-danger   { background: #b91c1c; border-color: #b91c1c; color: #fff; border-radius: 8px; }
        .btn-danger:hover { background: #dc2626; color: #fff; }

        .btn-warning  { background: #9a6700; border-color: #9a6700; color: #fff; border-radius: 8px; }
        .btn-warning:hover { background: #b07800; color: #fff; }

        .btn-close { filter: invert(1); }

        /* ── BADGES ── */
        .badge-custom {
            display: inline-flex; align-items: center;
            font-size: .72rem; font-weight: 700;
            padding: .25rem .65rem; border-radius: 20px;
            text-transform: uppercase; letter-spacing: .04em;
        }
        .badge-success  { background: var(--badge-green-bg);  color: var(--badge-green);  }
        .badge-danger   { background: var(--badge-red-bg);    color: var(--badge-red);    }
        .badge-warning  { background: var(--badge-yellow-bg); color: var(--badge-yellow); }
        .badge-secondary{ background: #8b949e22; color: var(--text-secondary); }
        .badge-info     { background: var(--badge-blue-bg);   color: var(--badge-blue);   }

        /* ── ROLE CARDS — tema escuro correto ── */
        .role-card { transition: all .2s; }
        .role-card:hover {
            border-color: var(--blue-primary) !important;
            background: #1f6feb18 !important;
        }
        .role-card.selected {
            border-color: var(--blue-primary) !important;
            background: #1f6feb28 !important;
        }

        /* ── CABEÇALHO DE PÁGINA ── */
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.75rem; flex-wrap: wrap; gap: 1rem;
        }
        .page-header h1 {
            font-size: 1.5rem; font-weight: 700;
            color: var(--text-main); margin: 0;
        }
        .page-header p {
            font-size: .85rem; color: var(--text-secondary); margin: .2rem 0 0;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center; padding: 3.5rem 1rem; color: var(--text-secondary);
        }
        .empty-state .empty-icon { font-size: 2.5rem; margin-bottom: .75rem; }
        .empty-state p { font-size: .9rem; }

        /* ── ALERTAS ── */
        .alert-success {
            background: rgba(35,134,54,.15);
            border: 1px solid rgba(35,134,54,.3);
            color: #3fb950; border-radius: 10px;
        }
        .alert-danger {
            background: rgba(185,28,28,.15);
            border: 1px solid rgba(185,28,28,.3);
            color: #f85149; border-radius: 10px;
        }

        /* ── PAGINAÇÃO ── */
        .page-link {
            background: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-secondary);
            border-radius: 6px !important;
        }
        .page-item.active .page-link {
            background: var(--blue-primary);
            border-color: var(--blue-primary);
            color: #fff;
        }
        .page-link:hover { background: var(--hover-bg); color: var(--text-main); }
        .page-item.disabled .page-link { opacity: .4; }
    </style>

    @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<nav id="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-mortarboard-fill me-2" style="color: var(--blue-primary);"></i>
        Aprender & Crescer
    </div>

    <ul class="nav flex-column mt-2">

        @if(auth()->user()->isAdmin())

            <li><a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a></li>

            <li class="sidebar-section">Gestão</li>

            <li><a href="{{ route('admin.usuarios.index') }}"
                   class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Usuários
            </a></li>

            <li><a href="{{ route('admin.turmas.index') }}"
                   class="nav-link {{ request()->routeIs('admin.turmas.*') ? 'active' : '' }}">
                <i class="bi bi-collection-fill"></i> Turmas
            </a></li>

            <li><a href="{{ route('admin.avisos.index') }}"
                   class="nav-link {{ request()->routeIs('admin.avisos.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone-fill"></i> Avisos
            </a></li>

            <li><a href="{{ route('admin.reservas.index') }}"
                   class="nav-link {{ request()->routeIs('admin.reservas.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check-fill"></i> Reservas
            </a></li>

            <li><a href="{{ route('admin.grade.index') }}"
                   class="nav-link {{ request()->routeIs('admin.grade.*') ? 'active' : '' }}">
                <i class="bi bi-grid-3x3-gap-fill"></i> Horários
            </a></li>

            <li class="sidebar-section">Módulos</li>

            <li><a href="{{ route('admin.biblioteca.index') }}"
                   class="nav-link {{ request()->routeIs('admin.biblioteca.*') ? 'active' : '' }}">
                <i class="bi bi-book-fill"></i> Biblioteca
            </a></li>

            <li><a href="{{ route('admin.cantina.index') }}"
                   class="nav-link {{ request()->routeIs('admin.cantina.*') ? 'active' : '' }}">
                <i class="bi bi-bag-fill"></i> Cantina
            </a></li>

        @elseif(auth()->user()->isAluno())

            <li><a href="{{ route('aluno.dashboard') }}"
                   class="nav-link {{ request()->routeIs('aluno.dashboard') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> Perfil
            </a></li>

            <li class="sidebar-section">Acadêmico</li>

            <li><a href="{{ route('aluno.avisos') }}"
                   class="nav-link {{ request()->routeIs('aluno.avisos') ? 'active' : '' }}">
                <i class="bi bi-megaphone-fill"></i> Avisos
            </a></li>

            <li><a href="{{ route('aluno.horarios') }}"
                   class="nav-link {{ request()->routeIs('aluno.horarios') ? 'active' : '' }}">
                <i class="bi bi-grid-3x3-gap-fill"></i> Horários
            </a></li>

            <li class="sidebar-section">Módulos</li>

            <li><a href="{{ route('biblioteca.index') }}"
                   class="nav-link {{ request()->routeIs('biblioteca.*') ? 'active' : '' }}">
                <i class="bi bi-book-fill"></i> Biblioteca
            </a></li>

            <li><a href="{{ route('cantina.index') }}"
                   class="nav-link {{ request()->routeIs('cantina.*') ? 'active' : '' }}">
                <i class="bi bi-bag-fill"></i> Cantina
            </a></li>

        @elseif(auth()->user()->isProfessor())

            <li><a href="{{ route('professor.dashboard') }}"
                   class="nav-link {{ request()->routeIs('professor.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a></li>

            <li class="sidebar-section">Acadêmico</li>

            <li><a href="{{ route('professor.avisos') }}"
                   class="nav-link {{ request()->routeIs('professor.avisos') ? 'active' : '' }}">
                <i class="bi bi-megaphone-fill"></i> Avisos
            </a></li>

            <li><a href="{{ route('professor.horarios') }}"
                   class="nav-link {{ request()->routeIs('professor.horarios') ? 'active' : '' }}">
                <i class="bi bi-grid-3x3-gap-fill"></i> Horários
            </a></li>

            <li><a href="{{ route('professor.reservas.index') }}"
                   class="nav-link {{ request()->routeIs('professor.reservas.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check-fill"></i> Reservas
            </a></li>

            <li class="sidebar-section">Módulos</li>

            <li><a href="{{ route('biblioteca.index') }}"
                   class="nav-link {{ request()->routeIs('biblioteca.*') ? 'active' : '' }}">
                <i class="bi bi-book-fill"></i> Biblioteca
            </a></li>

            <li><a href="{{ route('cantina.index') }}"
                   class="nav-link {{ request()->routeIs('cantina.*') ? 'active' : '' }}">
                <i class="bi bi-bag-fill"></i> Cantina
            </a></li>

        @endif

    </ul>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="nav-link w-100 border-0 bg-transparent text-start"
                    style="color:rgba(230,237,243,.5);">
                <i class="bi bi-box-arrow-left"></i> Sair
            </button>
        </form>
    </div>
</nav>

{{-- TOPBAR --}}
<div id="topbar">
    <span class="page-title">@yield('titulo', 'Dashboard')</span>
    <div class="d-flex align-items-center gap-2">
        <span style="color: var(--text-secondary); font-size:.88rem;">
            {{ auth()->user()->name }}
        </span>
        <div class="rounded-circle d-flex align-items-center justify-content-center"
             style="width:34px;height:34px;background:var(--blue-primary);color:#fff;font-weight:700;font-size:.8rem;">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    </div>
</div>

{{-- CONTEÚDO --}}
<div id="main-content">

    @if(session('sucesso'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('sucesso') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('erro'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('erro') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('conteudo')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>