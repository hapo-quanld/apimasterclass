<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\AuthorsController;
use App\Http\Controllers\Api\V1\AuthorTicketController;
use App\Models\Ticket;


//http://127.0.0.1:8000/api
//url (universal resource locatior)
//tickets
//users
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('tickets', TicketController::class);
    Route::apiResource('authors', AuthorsController::class);
    Route::apiResource('authors.tickets', AuthorTicketController::class);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
