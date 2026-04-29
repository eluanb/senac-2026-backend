<?php

use App\Http\Controllers\Api\ApiTicketController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::post('/tokens/create', function (Request $request) {

    $user = User::where('email', $request->email)->first();
    if(!$user) {
        return response()->json(['message' => 'Não autorizado'], 401);
    }

    if (!Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Não autorizado'], 401);
    }

    $token = $user->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/tickets', function (Request $request) {
        return ApiTicketController::getTickets($request);
    });

});