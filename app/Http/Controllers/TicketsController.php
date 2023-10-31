<?php

namespace App\Http\Controllers;

use App\Models\Tickets;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function index()
    {
        $tickets = Tickets::all(); //Coleta do banco todos os campos do ticket

        return view('admin.tickets.index', compact('tickets')); //compact -> passa um array com tudo que contém no tickets
    }
}
