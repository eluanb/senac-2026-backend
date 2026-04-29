<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    public function index()
    {
        return view('ticket', [
            'chamados' => Ticket::all()
        ]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status'      => 'required|in:Aberto,Pendente,Resolvido,Cancelado',
        ]);

        $validated['user_id'] = $request->user()->id;

        Ticket::create($validated);

        return redirect()->route('tickets.index')->with('success', 'Chamado criado com sucesso!');
    }


}
