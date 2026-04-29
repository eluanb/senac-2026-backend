<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function show(Ticket $ticket)
    {
        $user = Auth::user();
        $role = $user->role ?? 'usuario';

        if ($role === 'usuario' && (int) $ticket->user_id !== (int) $user->id) {
            abort(403, 'Voce nao tem permissao para acessar este chat.');
        }

        if ($role === 'atendente' && $ticket->assigned_to !== null && (int) $ticket->assigned_to !== (int) $user->id) {
            abort(403, 'Este chamado ja esta em atendimento por outro atendente.');
        }

        $ticket->load(['owner:id,name', 'attendant:id,name']);

        $canClaim = $role === 'atendente' && $ticket->assigned_to === null;
        $isMyAttendance = $role === 'atendente' && (int) $ticket->assigned_to === (int) $user->id;

        $secret = env('CHAT_SECRET', 'senac-chat-secret-local');

        $payload = base64_encode(json_encode([
            'ticketId' => $ticket->id,
            'userId'   => $user->id,
            'role'     => $user->role,
            'name'     => $user->name,
            'exp'      => time() + 7200,
        ]));

        $sig   = hash_hmac('sha256', $payload, $secret);
        $token = $payload . '.' . $sig;

        return view('chat', compact('ticket', 'token', 'canClaim', 'isMyAttendance'));
    }

    public function take(Request $request, Ticket $ticket)
    {
        $user = $request->user();

        if (($user->role ?? 'usuario') !== 'atendente') {
            abort(403, 'Apenas atendentes podem assumir chamados.');
        }

        if ($ticket->assigned_to !== null && (int) $ticket->assigned_to !== (int) $user->id) {
            return back()->with('chat_error', 'Este chamado ja esta em atendimento por outro atendente.');
        }

        if ($ticket->assigned_to === null) {
            $ticket->assigned_to = $user->id;
            $ticket->save();
        }

        return back()->with('chat_success', 'Voce assumiu este atendimento.');
    }
}
