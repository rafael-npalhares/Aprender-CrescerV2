<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;

class ReservaAdminController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with(['professor', 'sala', 'equipamento'])
                           ->orderBy('data')
                           ->paginate(15);

        return view('admin.reservas.index', compact('reservas'));
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