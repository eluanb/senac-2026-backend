<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{

    public function index()
    {
        return view('ticket', [
            'chamados' => Ticket::all()
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->header('x-api-user');
        $pass = $request->header('x-api-pass');

        if (Auth::attempt(['email' => $user, 'password' => $pass])) {
            $ticket = Ticket::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'status' => 'open',
            ]);

            return response()->json($ticket, 201);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
    }


}
