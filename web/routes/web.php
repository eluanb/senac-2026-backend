<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Web\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/auth', [LoginController::class, 'auth'])->name('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    


    Route::get('/chamados', [TicketController::class, 'index'])->name('tickets.index');
    Route::post('/chamados', [TicketController::class, 'create'])->name('tickets.store');
    Route::get('/chamados/{ticket}/chat', [ChatController::class, 'show'])->name('tickets.chat');
    Route::post('/chamados/{ticket}/atender', [ChatController::class, 'take'])->name('tickets.take');
});