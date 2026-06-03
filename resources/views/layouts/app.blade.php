<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Aprender & Crescer')</title>

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
    {{-- CSS próprio --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>
<body>

<div class="layout-wrapper">

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}" class="brand-logo">
                <div class="brand-icon">🎓</div>
                <div class="brand-name">
                    Aprender & Crescer
                    <span>Senai Joinville</span>
                </div>
            </a>
        </div>

        <p class="sidebar-section-label">Principal</p>

        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') || request()->routeIs('*.dashboard') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
            </li>
        </ul>

        <p class="sidebar-section-label">Escola</p>

        <ul class="sidebar-nav">
            <li>
                @if(auth()->user()->isProfessor())
                    <a href="{{ route('professor.avisos') }}"
                       class="{{ request()->routeIs('professor.avisos') ? 'active' : '' }}">
                @else
                    <a href="{{ route('aluno.avisos') }}"
                       class="{{ request()->routeIs('aluno.avisos') ? 'active' : '' }}">
                @endif
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    Avisos
                </a>
            </li>
            <li>
                @if(auth()->user()->isProfessor())
                    <a href="{{ route('professor.horarios') }}"
                       class="{{ request()->routeIs('professor.horarios') ? 'active' : '' }}">
                @else
                    <a href="{{ route('aluno.horarios') }}"
                       class="{{ request()->routeIs('aluno.horarios') ? 'active' : '' }}">
                @endif
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Horários
                </a>
            </li>

            @if(auth()->user()->isProfessor())
            <li>
                <a href="{{ route('professor.reservas.index') }}"
                   class="{{ request()->routeIs('professor.reservas.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Minhas Reservas
                </a>
            </li>
            @endif
        </ul>

        <p class="sidebar-section-label">Serviços</p>

        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('biblioteca.index') }}"
                   class="{{ request()->routeIs('biblioteca.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Biblioteca
                </a>
            </li>
            <li>
                <a href="{{ route('cantina.index') }}"
                   class="{{ request()->routeIs('cantina.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Cantina
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name ?? 'Usuário' }}</div>
                    <div class="user-role">{{ auth()->user()->role ?? '' }}</div>
                </div>
            </div>
        </div>

    </aside>

    {{-- OVERLAY MOBILE --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    {{-- CONTEÚDO PRINCIPAL --}}
    <div class="main-content">

        {{-- TOPBAR --}}
        <header class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>
                <div>
                    <div class="topbar-title">@yield('titulo', 'Dashboard')</div>
                    @hasSection('breadcrumb')
                        <div class="topbar-breadcrumb">@yield('breadcrumb')</div>
                    @endif
                </div>
            </div>
            <div class="topbar-right">
                <div class="topbar-user">
                    <div class="topbar-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    {{ auth()->user()->name ?? 'Usuário' }}
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm">Sair</button>
                </form>
            </div>
        </header>

        {{-- CONTEÚDO --}}
        <main class="page-content">
            @yield('conteudo')
        </main>

    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebarOverlay').classList.toggle('active');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('active');
    }
</script>

@stack('scripts')

</body>
</html>