<?php

use App\Http\Controllers\Api\projectController;
use App\Http\Controllers\Api\ticketController;
use App\Http\Controllers\Api\userController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [userController::class, 'register']);
Route::post('/login', [userController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
  Route::get('/user', function (Request $request){
    return $request->user();
  });

  Route::get('projects', [projectController::class, 'index']);
  // Route::get('tickets', [ticketController::class, 'index']);
  Route::get('tickets', [ticketController::class, 'getTicketByProject']);
  Route::get('ticket/{ticket}', [ticketController::class, 'getTicketById']);
  Route::post('ticket', [ticketController::class, 'createTicket']);
  Route::patch('ticket/{ticket}', [ticketController::class, 'updateTicket']);
  Route::delete('ticket/{ticket}', [ticketController::class, 'deleteTicket']);
}

);

