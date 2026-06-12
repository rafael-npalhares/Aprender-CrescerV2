{{-- resources/views/cantina/index.blade.php --}}
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cantina — Aprender & Crescer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-w: 240px;
            --bg: #0f1117;
            --surface: #1a1d2e;
            --surface2: #21253a;
            --border: rgba(255,255,255,.07);
            --text: #e8eaf0;
            --muted: #6b7494;
            --blue: #3b6ef8;
            --blue-dim: rgba(59,110,248,.15);
        }

        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; display: flex; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w); min-height: 100vh; background: #13162a;
            border-right: 1px solid var(--border); display: flex; flex-direction: column;
            padding: 1.5rem 0; position: fixed; top: 0; left: 0; bottom: 0; z-index: 100; flex-shrink: 0;
        }
        .sidebar-brand { display: flex; align-items: center; gap: .65rem; padding: 0 1.25rem 1.75rem; border-bottom: 1px solid var(--border); }
        .brand-icon { width: 36px; height: 36px; background: var(--blue); border-radius: 9px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.1rem; flex-shrink: 0; }
        .brand-text { font-family: 'DM Serif Display', serif; font-size: 1rem; color: #fff; line-height: 1.2; }
        .brand-sub  { font-size: .68rem; color: var(--muted); letter-spacing: .04em; }
        .nav-section { padding: 1.25rem 1rem .4rem; font-size: .65rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); }
        .nav-item { display: flex; align-items: center; gap: .7rem; padding: .55rem 1.25rem; font-size: .875rem; color: rgba(255,255,255,.6); text-decoration: none; transition: background .15s, color .15s; border-left: 3px solid transparent; }
        .nav-item:hover { background: rgba(255,255,255,.04); color: #fff; }
        .nav-item.active { background: var(--blue-dim); color: #fff; border-left-color: var(--blue); }
        .nav-item i { font-size: 1rem; width: 18px; text-align: center; }
        .sidebar-footer { margin-top: auto; padding: 1rem 1.25rem 0; border-top: 1px solid var(--border); }
        .sidebar-footer a { display: flex; align-items: center; gap: .65rem; color: var(--muted); font-size: .875rem; text-decoration: none; padding: .5rem 0; }
        .sidebar-footer a:hover { color: #ef4444; }

        /* ── MAIN ── */
        .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar { height: 60px; background: #13162a; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; position: sticky; top: 0; z-index: 50; }
        .topbar-title { font-size: .95rem; color: var(--muted); font-weight: 500; }
        .topbar-user { display: flex; align-items: center; gap: .6rem; font-size: .875rem; color: var(--text); }
        .avatar { width: 34px; height: 34px; background: var(--blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: .85rem; color: #fff; }
        .content { padding: 2rem; }

        /* ── PAGE HEADER ── */
        .page-header { margin-bottom: 2rem; }
        .page-header h1 { font-family: 'DM Serif Display', serif; font-size: 2rem; color: #fff; margin-bottom: .25rem; }
        .page-header p  { color: var(--muted); font-size: .9rem; }

        /* ── DAY TABS ── */
        .day-tabs { display: flex; gap: .5rem; margin-bottom: 2rem; border-bottom: 1px solid var(--border); padding-bottom: .75rem; flex-wrap: wrap; }
        .day-tab { padding: .45rem 1.1rem; border-radius: 8px; font-size: .85rem; font-weight: 600; cursor: pointer; border: 1px solid var(--border); background: var(--surface); color: var(--muted); transition: all .2s; text-transform: uppercase; letter-spacing: .05em; }
        .day-tab:hover { border-color: var(--blue); color: #fff; }
        .day-tab.active { background: var(--blue); border-color: var(--blue); color: #fff; }
        .day-tab .dot { display: inline-block; width: 7px; height: 7px; border-radius: 50%; margin-right: 5px; background: currentColor; opacity: .7; }

        /* ── DAY PANEL ── */
        .day-panel { display: none; }
        .day-panel.active { display: block; animation: fadeUp .3s ease both; }
        @keyframes fadeUp { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
        .day-panel-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
        .day-panel-header h2 { font-family: 'DM Serif Display', serif; font-size: 1.4rem; color: #fff; }
        .day-panel-header .day-date { font-size: .8rem; color: var(--muted); }

        /* ── FOOD GRID ── */
        .food-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(270px, 1fr)); gap: 1.25rem; }

        /* ── FOOD CARD ── */
        .food-card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; transition: transform .2s, box-shadow .2s; position: relative; }
        .food-card:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(0,0,0,.35); }
        .food-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
        .food-card.accent-blue::before   { background: linear-gradient(90deg,#3b6ef8,#60a5fa); }
        .food-card.accent-green::before  { background: linear-gradient(90deg,#22c55e,#86efac); }
        .food-card.accent-yellow::before { background: linear-gradient(90deg,#f59e0b,#fcd34d); }
        .food-card.accent-red::before    { background: linear-gradient(90deg,#ef4444,#fca5a5); }
        .food-card.accent-purple::before { background: linear-gradient(90deg,#a855f7,#d8b4fe); }

        .food-img-wrap { width: 100%; height: 180px; overflow: hidden; position: relative; background: var(--surface2); }
        .food-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s ease; }
        .food-card:hover .food-img-wrap img { transform: scale(1.05); }
        .food-img-wrap .badge-sem-estoque { position: absolute; inset: 0; background: rgba(0,0,0,.65); display: flex; align-items: center; justify-content: center; font-size: .8rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #ef4444; gap: .4rem; }

        .food-body { padding: 1rem 1.1rem 1.1rem; }
        .food-name { font-weight: 700; font-size: 1rem; color: #fff; margin-bottom: .2rem; }
        .food-desc { font-size: .8rem; color: var(--muted); line-height: 1.5; margin-bottom: .85rem; }
        .food-footer { display: flex; align-items: center; justify-content: space-between; }
        .food-price { font-family: 'DM Serif Display', serif; font-size: 1.3rem; color: #fff; }
        .food-price span { font-family: 'DM Sans', sans-serif; font-size: .75rem; color: var(--muted); font-weight: 400; }

        /* ── STOCK INDICATOR ── */
        .stock-indicator { display: flex; align-items: center; gap: .5rem; }
        .stock-dot { width: 13px; height: 13px; border-radius: 50%; flex-shrink: 0; transition: background .4s, box-shadow .4s; }
        .stock-dot.full  { background: #22c55e; box-shadow: 0 0 8px rgba(34,197,94,.5); }
        .stock-dot.half  { background: #f59e0b; box-shadow: 0 0 8px rgba(245,158,11,.5); }
        .stock-dot.empty { background: #ef4444; box-shadow: 0 0 8px rgba(239,68,68,.5); }
        .stock-label { font-size: .78rem; color: var(--muted); font-weight: 500; }

        /* ── ADMIN EDIT BUTTON ── */
        .btn-edit-card { position: absolute; top: .7rem; right: .7rem; width: 32px; height: 32px; border-radius: 8px; background: rgba(0,0,0,.55); border: 1px solid rgba(255,255,255,.1); display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: .9rem; cursor: pointer; transition: background .15s, color .15s; text-decoration: none; z-index: 2; }
        .btn-edit-card:hover { background: var(--blue); color: #fff; border-color: var(--blue); }

        /* ── MODAL ── */
        .modal-content { background: #1e2235; border: 1px solid var(--border); border-radius: 14px; color: var(--text); }
        .modal-header { border-bottom: 1px solid var(--border); padding: 1.25rem 1.5rem; }
        .modal-title  { font-family: 'DM Serif Display', serif; font-size: 1.3rem; color: #fff; }
        .btn-close    { filter: invert(1) brightness(.6); }
        .modal-body   { padding: 1.5rem; }
        .modal-footer { border-top: 1px solid var(--border); padding: 1rem 1.5rem; }
        .form-label-dark { font-size: .78rem; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; color: var(--muted); margin-bottom: .4rem; }
        .form-control-dark, .form-select-dark { background: var(--bg); border: 1.5px solid var(--border); color: var(--text); border-radius: 9px; padding: .55rem .9rem; font-size: .9rem; width: 100%; transition: border-color .2s; }
        .form-control-dark:focus, .form-select-dark:focus { border-color: var(--blue); outline: none; background: var(--bg); box-shadow: 0 0 0 3px rgba(59,110,248,.12); color: var(--text); }

        /* stock level picker */
        .stock-picker { display: flex; gap: .75rem; margin-top: .3rem; }
        .stock-option { flex: 1; padding: .6rem; border-radius: 9px; border: 1.5px solid var(--border); background: var(--bg); cursor: pointer; text-align: center; font-size: .8rem; font-weight: 600; color: var(--muted); transition: all .2s; }
        .stock-option:hover { border-color: rgba(255,255,255,.25); color: #fff; }
        .stock-option .s-dot { width: 14px; height: 14px; border-radius: 50%; margin: 0 auto .4rem; }
        .stock-option.selected.green  { border-color: #22c55e; color: #22c55e; background: rgba(34,197,94,.08); }
        .stock-option.selected.yellow { border-color: #f59e0b; color: #f59e0b; background: rgba(245,158,11,.08); }
        .stock-option.selected.red    { border-color: #ef4444; color: #ef4444; background: rgba(239,68,68,.08); }

        .btn-save { background: var(--blue); color: #fff; border: none; border-radius: 9px; padding: .55rem 1.5rem; font-weight: 600; font-size: .9rem; cursor: pointer; transition: background .2s; }
        .btn-save:hover { background: #2a5ce6; }
        .btn-cancel { background: transparent; color: var(--muted); border: 1px solid var(--border); border-radius: 9px; padding: .55rem 1.2rem; font-size: .9rem; cursor: pointer; transition: all .2s; }
        .btn-cancel:hover { color: #fff; border-color: rgba(255,255,255,.25); }

        @media (max-width: 768px) { .sidebar { display: none; } .main { margin-left: 0; } .content { padding: 1.25rem; } }
    </style>
</head>
<body>

@php $role = Auth::user()->role; @endphp

{{-- ── SIDEBAR ── --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
        <div>
            <div class="brand-text">Aprender & Crescer</div>
            <div class="brand-sub">Senai Joinville</div>
        </div>
    </div>

    <div class="nav-section">Gestão</div>
    <a href="{{ route($role . '.dashboard') }}"        class="nav-item"><i class="bi bi-grid-1x2"></i> Dashboard</a>

    @if($role === 'admin')
        <a href="{{ route('admin.usuarios.index') }}"  class="nav-item"><i class="bi bi-people"></i> Usuários</a>
        <a href="{{ route('admin.turmas.index') }}"    class="nav-item"><i class="bi bi-collection"></i> Turmas</a>
        <a href="{{ route('admin.avisos.index') }}"    class="nav-item"><i class="bi bi-megaphone"></i> Avisos</a>
        <a href="{{ route('admin.reservas.index') }}"  class="nav-item"><i class="bi bi-calendar-check"></i> Reservas</a>
        <a href="{{ route('admin.grade.index') }}"     class="nav-item"><i class="bi bi-clock"></i> Horários</a>
    @else
        <a href="{{ route($role . '.avisos') }}"       class="nav-item"><i class="bi bi-megaphone"></i> Avisos</a>
        <a href="{{ route($role . '.horarios') }}"     class="nav-item"><i class="bi bi-clock"></i> Horários</a>
        @if($role === 'professor')
            <a href="{{ route('professor.reservas.index') }}" class="nav-item"><i class="bi bi-calendar-check"></i> Reservas</a>
        @endif
    @endif

    <div class="nav-section">Módulos</div>
    <a href="{{ route($role . '.biblioteca.index') }}" class="nav-item"><i class="bi bi-book"></i> Biblioteca</a>
    <a href="{{ route($role . '.cantina.index') }}"    class="nav-item active"><i class="bi bi-shop"></i> Cantina</a>

    <div class="sidebar-footer">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left"></i> Sair
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>
</aside>

{{-- ── MAIN ── --}}
<div class="main">
    <div class="topbar">
        <span class="topbar-title">Cantina / Cardápio semanal</span>
        <div class="topbar-user">
            <span>{{ Auth::user()->name }}</span>
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
        </div>
    </div>

    <div class="content">

        @if(session('success'))
            <div class="alert alert-success py-2 mb-3" style="font-size:.85rem;border-radius:10px;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#86efac;">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="page-header">
            <h1>🍽️ Cardápio da Semana</h1>
            <p>Confira o cardápio de cada dia e o nível de estoque disponível.</p>
        </div>

        {{-- ── DAY TABS ── --}}
        <div class="day-tabs">
            @php
                $dias = ['seg' => 'Segunda', 'ter' => 'Terça', 'qua' => 'Quarta', 'qui' => 'Quinta', 'sex' => 'Sexta'];
                $hoje = match(now()->dayOfWeek) { 1=>'seg', 2=>'ter', 3=>'qua', 4=>'qui', 5=>'sex', default=>'seg' };
            @endphp
            @foreach($dias as $key => $label)
                <div class="day-tab {{ $key === $hoje ? 'active' : '' }}" data-day="{{ $key }}">
                    <span class="dot"></span>{{ $label }}
                </div>
            @endforeach
        </div>

        {{-- ── DAY PANELS ── --}}
        @foreach($cardapio as $dia => $itens)
        <div class="day-panel {{ $dia === $hoje ? 'active' : '' }}" id="panel-{{ $dia }}">
            <div class="day-panel-header">
                <h2>{{ $dias[$dia] }}-feira</h2>
                <span class="day-date">{{ count($itens) }} {{ count($itens) === 1 ? 'item' : 'itens' }} no cardápio</span>
            </div>

            <div class="food-grid">
                @foreach($itens as $item)
                @php
                    $accents    = ['accent-blue','accent-green','accent-yellow','accent-red','accent-purple'];
                    $accent     = $accents[$loop->index % count($accents)];
                    $stockClass = match($item['estoque']) { 'full'=>'full', 'half'=>'half', default=>'empty' };
                    $stockLabel = match($item['estoque']) { 'full'=>'Disponível', 'half'=>'Pouco estoque', default=>'Sem estoque' };
                @endphp
                <div class="food-card {{ $accent }}">

                    @if($role === 'admin')
                    <a href="#" class="btn-edit-card"
                       data-bs-toggle="modal" data-bs-target="#modalEdit"
                       data-id="{{ $item['id'] }}"
                       data-name="{{ $item['nome'] }}"
                       data-desc="{{ $item['descricao'] }}"
                       data-price="{{ $item['preco'] }}"
                       data-stock="{{ $item['estoque'] }}"
                       title="Editar item">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    @endif

                    <div class="food-img-wrap">
                        <img src="{{ asset('storage/' . $item['foto']) }}" alt="{{ $item['nome'] }}" loading="lazy">
                        @if($item['estoque'] === 'empty')
                            <div class="badge-sem-estoque"><i class="bi bi-x-circle-fill"></i> Esgotado</div>
                        @endif
                    </div>

                    <div class="food-body">
                        <div class="food-name">{{ $item['nome'] }}</div>
                        <div class="food-desc">{{ $item['descricao'] }}</div>
                        <div class="food-footer">
                            <div class="food-price">
                                <span>R$</span> {{ number_format($item['preco'], 2, ',', '.') }}
                            </div>
                            <div class="stock-indicator">
                                <div class="stock-dot {{ $stockClass }}"></div>
                                <span class="stock-label">{{ $stockLabel }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

    </div>{{-- /content --}}
</div>{{-- /main --}}

{{-- ── MODAL EDITAR (admin only) ── --}}
@if($role === 'admin')
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-fill me-2" style="color:var(--blue)"></i>Editar item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEdit" method="POST" action="" enctype="multipart/form-data">
                @csrf @method('PATCH')
                <div class="modal-body d-flex flex-column gap-3">

                    <div>
                        <div class="form-label-dark">Nome do item</div>
                        <input type="text" name="nome" id="edit-nome" class="form-control-dark" required>
                    </div>

                    <div>
                        <div class="form-label-dark">Descrição</div>
                        <textarea name="descricao" id="edit-desc" class="form-control-dark" rows="2" style="resize:none;"></textarea>
                    </div>

                    <div>
                        <div class="form-label-dark">Preço (R$)</div>
                        <input type="number" step="0.01" name="preco" id="edit-preco" class="form-control-dark" required>
                    </div>

                    <div>
                        <div class="form-label-dark">Foto (opcional — deixe vazio para manter)</div>
                        <input type="file" name="foto" accept="image/*" class="form-control-dark" style="padding:.45rem .9rem;">
                    </div>

                    <div>
                        <div class="form-label-dark">Nível de estoque</div>
                        <div class="stock-picker">
                            <div class="stock-option green" data-val="full" onclick="selectStock(this)">
                                <div class="s-dot" style="background:#22c55e;"></div>Cheio
                            </div>
                            <div class="stock-option yellow" data-val="half" onclick="selectStock(this)">
                                <div class="s-dot" style="background:#f59e0b;"></div>Metade
                            </div>
                            <div class="stock-option red" data-val="empty" onclick="selectStock(this)">
                                <div class="s-dot" style="background:#ef4444;"></div>Vazio
                            </div>
                        </div>
                        <input type="hidden" name="estoque" id="edit-estoque">
                    </div>

                </div>
                <div class="modal-footer gap-2">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-save"><i class="bi bi-check-lg me-1"></i>Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ── Day tabs ──
    document.querySelectorAll('.day-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.day-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.day-panel').forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            document.getElementById('panel-' + tab.dataset.day).classList.add('active');
        });
    });

    // ── Stock picker ──
    function selectStock(el) {
        document.querySelectorAll('.stock-option').forEach(o => o.classList.remove('selected'));
        el.classList.add('selected');
        document.getElementById('edit-estoque').value = el.dataset.val;
    }

    // ── Fill modal on open ──
    document.getElementById('modalEdit')?.addEventListener('show.bs.modal', function(e) {
        const btn = e.relatedTarget;
        document.getElementById('edit-nome').value  = btn.dataset.name;
        document.getElementById('edit-desc').value  = btn.dataset.desc;
        document.getElementById('edit-preco').value = btn.dataset.price;

        // Monta a URL usando a rota correta do web.php: admin.cantina.produtos.update
        document.getElementById('formEdit').action =
            '{{ url("admin/cantina/produtos") }}/' + btn.dataset.id;

        // reset & select stock
        document.querySelectorAll('.stock-option').forEach(o => o.classList.remove('selected'));
        const target = document.querySelector(`.stock-option[data-val="${btn.dataset.stock}"]`);
        if (target) target.classList.add('selected');
        document.getElementById('edit-estoque').value = btn.dataset.stock;
    });
</script>
</body>
</html>