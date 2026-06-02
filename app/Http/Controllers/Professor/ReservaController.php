<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Sala;
use App\Models\Equipamento;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::where('professor_id', auth()->id())
                           ->with(['sala', 'equipamento'])
                           ->latest()->paginate(10);

        return view('professor.reservas.index', compact('reservas'));
    }

    public function create()
    {
        $salas        = Sala::where('disponivel', true)->get();
        $equipamentos = Equipamento::where('disponivel', true)->get();

        return view('professor.reservas.create', compact('salas', 'equipamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data'           => 'required|date|after_or_equal:today',
            'horario_inicio' => 'required',
            'horario_fim'    => 'required|after:horario_inicio',
            'finalidade'     => 'nullable|string',
            'sala_id'        => 'nullable|exists:salas,id',
            'equipamento_id' => 'nullable|exists:equipamentos,id',
        ]);

        Reserva::create([
            'professor_id'   => auth()->id(),
            'data'           => $request->data,
            'horario_inicio' => $request->horario_inicio,
            'horario_fim'    => $request->horario_fim,
            'finalidade'     => $request->finalidade,
            'sala_id'        => $request->sala_id,
            'equipamento_id' => $request->equipamento_id,
            'status'         => 'pendente',
        ]);

        return redirect()->route('professor.reservas.index')
                         ->with('sucesso', 'Reserva solicitada! Aguarde aprovação.');
    }

    public function destroy(Reserva $reserva)
    {
        // Garante que só cancela a própria reserva
        if ($reserva->professor_id !== auth()->id()) {
            abort(403);
        }

        $reserva->delete();

        return redirect()->route('professor.reservas.index')
                         ->with('sucesso', 'Reserva cancelada.');
    }
}