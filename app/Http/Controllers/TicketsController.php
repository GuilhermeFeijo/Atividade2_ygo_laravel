<?php

namespace App\Http\Controllers;

use App\Models\Tickets;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    //FUNCOES ADMIN
    public function adminIndex()
    {
        $tickets = Tickets::all(); //Coleta do banco todos os campos do ticket

        return view('admin.tickets.index', compact('tickets')); //compact -> passa um array com tudo que contém no tickets
    }

    //FUNCOES RESPONSIBLE

    //FUNCOES USER
    public function index()
    {
        $user = auth()->user(); //Coleta as informações do usuário logado

        $tickets = Tickets::where('user_id', $user->id)->get(); //Busca apenas os tickets abertos pelo usuário logado

        return view('user.tickets.index', compact('tickets')); //compact -> passa um array com tudo que contém no tickets
    }

    public function abertura()
    {
        return view('user.tickets.newTicket');
    }

    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        $requestData = $request->all();
        $requestData['user_id'] = $user_id;
        $requestData['created_by'] = $user_id;

        $horaAtual = Carbon::now();
        $requestData['open_at'] = $horaAtual;
        $requestData['created_at'] = $horaAtual;

        // Encontrar o último número de protocolo
        $protocolo = Tickets::max('protocol') + 1;
        $requestData['protocol'] = $protocolo;
        Tickets::create($requestData);

        return redirect()->route('user.index');
    }
}
