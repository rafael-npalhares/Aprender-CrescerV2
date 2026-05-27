<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlunoController extends Controller
{
    public function index(): View
    {
        return view('dashboard.aluno');
    }
}

