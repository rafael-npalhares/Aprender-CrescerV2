{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Aprender & Crescer')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #1a2238;
            --blue-primary: #2d6ef7;
            --page-bg: #f0f2f5;
            --border-color: #e8eaf0;
            --text-secondary: #8899bb;
        }
        body { background: var(--page-bg); }
        #sidebar {
            width: 250px; min-height: 100vh; background: var(--sidebar-bg);
            position: fixed; top: 0; left: 0; z-index: 100;
            display: flex; flex-direction: column;
        }
        #sidebar .sidebar-brand {
            padding: 1.5rem 1.25rem; color: #fff; font-weight: 700;
            font-size: 1.1rem; border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        #sidebar .nav-link {
            color: rgba(255,255,255,0.7); padding: .65rem 1.25rem;
            border-radius: 6px; margin: 2px 10px; font-size: .92rem;
            display: flex; align-items: center; gap: .6rem; transition: background .2s, color .2s;
        }
        #sidebar .nav-link:hover, #sidebar .nav-link.active {
            background: var(--blue-primary); color: #fff;
        }
        #sidebar .sidebar-footer { margin-top: auto; padding: 1rem; }
        #topbar {
            margin-left: 250px; height: 60px; background: #fff;
            border-bottom: 1px solid var(--border-color);
            display: flex; align-items: center; padding: 0 1.5rem;
            position: sticky; top: 0; z-index: 99; justify-content: space-between;
        }
        #main-content { margin-left: 250px; padding: 1.75rem; }
        .card { border: 1px solid var(--border-color); border-radius: 10px; }
    </style>
    @stack('styles')
</head>
<body>

<nav id="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-mortarboard-fill me-2" style="color:var(--blue-primary);"></i>
        Aprender & Crescer
    </div>

    <ul class="nav flex-column mt-2">
        {{-- Dashboard --}}
        @if(auth()->user()->isProfessor())
            <li><a href="{{ route('professor.dashboard') }}" class="nav-link {{ request()->routeIs('professor.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a></li>
        @else
            <li><a href="{{ route('aluno.dashboard') }}" class="nav-link {{ request()->routeIs('aluno.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a></li>
        @endif

        <li><a href="{{ route('aluno.avisos') }}" class="nav-link {{ request()->routeIs('*.avisos') ? 'active' : '' }}">
            <i class="bi bi-megaphone-fill"></i> Avisos
        </a></li>

        <li><a href="{{ route('aluno.horarios') }}" class="nav-link {{ request()->routeIs('*.horarios') ? 'active' : '' }}">
            <i class="bi bi-grid-3x3-gap-fill"></i> Horários
        </a></li>

        {{-- Exclusivo do professor --}}
        @if(auth()->user()->isProfessor())
            <li><a href="{{ route('professor.reservas.index') }}" class="nav-link {{ request()->routeIs('professor.reservas.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check-fill"></i> Minhas Reservas
            </a></li>
        @endif

        <li><a href="{{ route('biblioteca.index') }}" class="nav-link {{ request()->routeIs('biblioteca.*') ? 'active' : '' }}">
            <i class="bi bi-book-fill"></i> Biblioteca
        </a></li>

        <li><a href="{{ route('cantina.index') }}" class="nav-link {{ request()->routeIs('cantina.*') ? 'active' : '' }}">
            <i class="bi bi-bag-fill"></i> Cantina
        </a></li>
    </ul>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link w-100 border-0 bg-transparent text-start" style="color:rgba(255,255,255,.6);">
                <i class="bi bi-box-arrow-left"></i> Sair
            </button>
        </form>
    </div>
</nav>

<div id="topbar">
    <span class="fw-semibold" style="color:#1a2238;">@yield('titulo', 'Início')</span>
    <div class="d-flex align-items-center gap-2">
        <span style="color:var(--text-secondary);font-size:.9rem;">{{ auth()->user()->name }}</span>
        <div class="rounded-circle d-flex align-items-center justify-content-center"
             style="width:36px;height:36px;background:var(--blue-primary);color:#fff;font-weight:700;font-size:.85rem;">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    </div>
</div>

<div id="main-content">
    @yield('conteudo')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>