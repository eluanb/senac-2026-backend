<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;

class ApiTicketController
{

    public static function getTickets($request)
    {
        $tickets = Ticket::where('status', 'Aberto')
                         ->where('user_id', $request->user()->id)->get();

        return response()->json($tickets);
    }

}
