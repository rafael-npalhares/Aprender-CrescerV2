<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Aluno;
use App\Models\Professor;
use App\Models\Turma;
use App\Models\Aviso;
use App\Models\Reserva;
use App\Models\Emprestimo;
use App\Models\PedidoCantina;

class AdminController extends Controller
{
    public function index()
    {
        return view('dashboard.admin', [
            'totalUsuarios'                => User::count(),
            'totalAlunos'                  => Aluno::count(),
            'totalProfessores'             => Professor::count(),
            'totalTurmas'                  => Turma::where('ativa', true)->count(),
            'totalAvisosAtivos'            => Aviso::where('ativo', true)->count(),
            'totalReservasPendentes'       => Reserva::where('status', 'pendente')->count(),
            'totalEmprestimos'             => Emprestimo::where('status', 'ativo')->count(),
            'totalPedidosCantinaPendentes' => PedidoCantina::where('status', 'pendente')->count(),
            'ultimasReservas'              => Reserva::with('professor')->latest()->take(5)->get(),
            'ultimosAvisos'                => Aviso::where('ativo', true)->latest()->take(3)->get(),
        ]);
    }
}