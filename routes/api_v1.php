<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\AuthorsController;
use App\Http\Controllers\Api\V1\AuthorTicketController;
use App\Http\Controllers\Api\V1\UserController;
use App\Models\Ticket;


//http://127.0.0.1:8000/api
//url (universal resource locatior)
//tickets
//users
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('tickets', TicketController::class)->except(['update']);
    Route::put('tickets/{ticket}', [TicketController::class,'replace']);
    Route::patch('tickets/{ticket}', [TicketController::class,'update']);

    Route::apiResource('users', UserController::class)->except(['update']);
    Route::put('users/{user}', [UserController::class,'replace']);
    Route::patch('users/{user}', [UserController::class,'update']);

    Route::apiResource('authors', AuthorsController::class)->except(['store','update','delete']);
    Route::apiResource('authors.tickets', AuthorTicketController::class)->except(['update']);
    Route::put('authors/{author}/tickets/{ticket}', [AuthorTicketController::class,'replace']);
    Route::patch('authors/{author}/tickets/{ticket}', [AuthorTicketController::class,'update']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
