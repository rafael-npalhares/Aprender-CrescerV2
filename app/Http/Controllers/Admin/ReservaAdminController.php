<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\User;        // ← faltava este import
use App\Models\Sala;        // ← faltava este import
use App\Models\Equipamento; // ← faltava este import
use Illuminate\Http\Request;

class ReservaAdminController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with(['professor', 'sala', 'equipamento'])
                           ->orderBy('data')
                           ->paginate(15);

        return view('admin.reservas.index', compact('reservas'));
    }

    public function create()
    {
        $professores  = User::where('role', 'professor')->orderBy('name')->get();
        $salas        = Sala::where('disponivel', true)->get();
        $equipamentos = Equipamento::where('disponivel', true)->get();

        return view('admin.reservas.create', compact('professores', 'salas', 'equipamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'professor_id'   => 'required|exists:users,id',
            'data'           => 'required|date|after_or_equal:today',
            'horario_inicio' => 'required',
            'horario_fim'    => 'required|after:horario_inicio',
            'finalidade'     => 'nullable|string',
            'sala_id'        => 'nullable|exists:salas,id',
            'equipamento_id' => 'nullable|exists:equipamentos,id',
        ]);

        Reserva::create([
            'professor_id'   => $request->professor_id,
            'data'           => $request->data,
            'horario_inicio' => $request->horario_inicio,
            'horario_fim'    => $request->horario_fim,
            'finalidade'     => $request->finalidade,
            'sala_id'        => $request->sala_id,
            'equipamento_id' => $request->equipamento_id,
            'status'         => 'aprovada',
        ]);

        return redirect()->route('admin.reservas.index')
                         ->with('sucesso', 'Reserva criada com sucesso!');
    }

    public function aprovar(Reserva $reserva)
    {
        $reserva->update(['status' => 'aprovada']);

        return redirect()->route('admin.reservas.index')
                         ->with('sucesso', 'Reserva aprovada!');
    }

    public function negar(Reserva $reserva)
    {
        $reserva->update(['status' => 'negada']);

        return redirect()->route('admin.reservas.index')
                         ->with('sucesso', 'Reserva negada.');
    }

    public function destroy(Reserva $reserva)
    {
        $reserva->delete();

        return redirect()->route('admin.reservas.index')
                         ->with('sucesso', 'Reserva removida!');
    }
}