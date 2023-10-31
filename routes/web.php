<?php

use App\Http\Controllers\TicketsController;
use Illuminate\Support\Facades\Route;


//Rotas com login
Route::middleware(['auth'])->group(function(){
    //Tickets
    Route::get('/', [TicketsController::class, 'index'])->name('user.index');
    Route::get('/tickets/abertura', [TicketsController::class, 'abertura'])->name('user.tickets.newTicket');
    Route::post('/tickets/abertura', [TicketsController::class, 'store'])->name('user.tickets.store');
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
