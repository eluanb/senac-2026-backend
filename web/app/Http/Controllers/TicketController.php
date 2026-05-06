<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\OpenRouterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function aiSuggest(Ticket $ticket, OpenRouterService $ai)
    {
        try {
            $sugestao = $ai->sugerirSolucao(
                $ticket->title,
                $ticket->description,
                $ticket->status
            );

            return response()->json(['sugestao' => $sugestao]);
        } catch (\Throwable $e) {
            Log::error('Erro ao gerar sugestao de IA para chamado.', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage(),
            ]);

            $message = config('app.debug')
                ? 'Erro ao consultar IA: ' . $e->getMessage()
                : 'Erro ao consultar IA. Tente novamente em instantes.';

            return response()->json(['error' => $message], 500);
        }
    }
}
