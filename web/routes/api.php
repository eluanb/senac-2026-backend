<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;


Route::post('/tickets/store', [TicketController::class, 'store']);
Route::get('/tickets', [TicketController::class, 'index']);
