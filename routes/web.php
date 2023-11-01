<?php

use App\Http\Controllers\TicketsController;
use Illuminate\Support\Facades\Route;


//Rotas com login
Route::middleware(['auth'])->group(function(){
    //Tickets
    Route::get('/', [TicketsController::class, 'index'])->name('index');
    Route::get('/tickets/abertura', [TicketsController::class, 'abertura'])->name('tickets.newTicket');
    Route::post('/tickets/abertura', [TicketsController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{id}', [TicketsController::class, 'detalhe'])->name('tickets.detail');
    Route::put('/tickets/{id}', [TicketsController::class, 'apropriar'])->name('tickets.appropriate');
    Route::put('/tickets/finish/{id}', [TicketsController::class, 'encerrar'])->name('tickets.finish');
});


//Rotas sem login

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
