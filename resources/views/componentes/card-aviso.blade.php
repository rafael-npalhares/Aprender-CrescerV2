{{-- resources/views/componentes/card-aviso.blade.php --}}
<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <h6 class="card-title fw-semibold mb-1" style="color:#1a2238;">{{ $aviso->titulo }}</h6>
            <span class="badge" style="background:#f0f2f5;color:#8899bb;font-size:.75rem;">
                {{ $aviso->created_at->format('d/m/Y') }}
            </span>
        </div>
        <p class="card-text text-muted mb-0" style="font-size:.9rem;">{{ $aviso->descricao }}</p>
    </div>
</div>