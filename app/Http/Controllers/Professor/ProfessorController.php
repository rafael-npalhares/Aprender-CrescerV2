<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Aviso;
use App\Models\GradeHorario;
use App\Models\Reserva;

class ProfessorController extends Controller 
{
    public function index()
    {
        $avisos         = Aviso::where('ativo', true)
                               ->whereIn('visivel_para', ['todos', 'professores'])
                               ->latest()->take(5)->get();

        $minhasReservas = Reserva::where('professor_id', auth()->id())
                                 ->latest()->take(5)->get();

        return view('dashboard.professor', compact('avisos', 'minhasReservas'));
    }

    public function avisos()
    {
        $avisos = Aviso::where('ativo', true)
                       ->whereIn('visivel_para', ['todos', 'professores'])
                       ->latest()->paginate(10);

        return view('professor.avisos', compact('avisos'));
    }

    public function horarios()
    {
        $horarios = GradeHorario::where('professor_id', auth()->id())
                                ->with('turma')
                                ->orderBy('dia_semana')
                                ->get();

        return view('professor.horarios', compact('horarios'));
    }
}