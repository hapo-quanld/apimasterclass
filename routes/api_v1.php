<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Models\Ticket;


//http://127.0.0.1:8000/api
//url (universal resource locatior)
//tickets
//users
Route::prefix('v1')->group(function () {
    Route::apiResource('tickets', TicketController::class);
});

Route::middleware('auth:sanctum')->apiResource('tickets', TicketController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
