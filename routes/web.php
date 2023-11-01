<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DomainsController;
use App\Http\Controllers\TicketsController;
use Illuminate\Support\Facades\Auth;
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

    //Users
    Route::get('/users', [RegisteredUserController::class, 'index'])->name('user.index');
    Route::get('/users/cadastro', [RegisteredUserController::class, 'cadastro'])->name('user.register');
    Route::post('/users/cadastro', [RegisteredUserController::class, 'adminStore'])->name('user.store');
    Route::put('/users/desativar/{id}', [RegisteredUserController::class, 'desativar'])->name('user.deactivate');
    Route::put('/users/ativar/{id}', [RegisteredUserController::class, 'ativar'])->name('user.activate');
    Route::put('/users/permissao/{id}', [RegisteredUserController::class, 'permissao'])->name('user.permission');
    Route::delete('/users/delete/{id}', [RegisteredUserController::class, 'destroy'])->name('user.delete');

    //Domains
    Route::get('/domains', [DomainsController::class, 'index'])->name('domains.index');
    Route::get('/domains/cadastro', [DomainsController::class, 'cadastro'])->name('domains.newDomain');
    Route::post('/domains/cadastro', [DomainsController::class, 'store'])->name('domains.store');
    Route::put('/domains/desativar/{id}', [DomainsController::class, 'desativar'])->name('domain.deactivate');
    Route::put('/domains/ativar/{id}', [DomainsController::class, 'ativar'])->name('domain.activate');
    Route::delete('/domains/delete/{id}', [DomainsController::class, 'destroy'])->name('domain.delete');
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
