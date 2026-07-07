<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{

    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}