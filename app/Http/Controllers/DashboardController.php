<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        dd($user->role);

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isProfessor()) {
            return redirect()->route('professor.dashboard');
        }

        return redirect()->route('aluno.dashboard');
    }
}