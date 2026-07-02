<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isProfessor()) {
            return redirect()->route('professor.dashboard');
        }
        if ($user->isGerente()) {
            return redirect()->route('gerente.dashboard');
        }

        return redirect()->route('aluno.dashboard');
    }
}