<?php

namespace App\Http\Controllers;

use App\Http\Requests\CloseTicket;
use App\Http\Requests\StoreUpdateTicket;
use App\Models\Tickets;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TicketsController extends Controller
{

    public function index()
    {
        $user = auth()->user(); //Coleta as informações do usuário logado

        if($user->user_type == 'superadmin' || $user->user_type == 'responsable'){ //Se for admin entra na tela de todos os tickets

            $tickets = Tickets::all(); //Coleta do banco todos os campos do ticket

        }else{

            $tickets = Tickets::where('user_id', $user->id)->get(); //Busca apenas os tickets abertos pelo usuário logado

        }

        return view('user.tickets.index', compact('tickets', 'user')); //compact -> passa um array com tudo que contém no tickets
    }

    public function abertura()
    {
        return view('user.tickets.newTicket');
    }

    public function store(StoreUpdateTicket $request)
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

        return redirect()->route('index');
    }

    public function detalhe($id)
    {
        $user = auth()->user();

        if (!$tickets = Tickets::find($id)){
            return redirect()
            ->route('index')
            ->with('message', 'Ticket não localizado');
        };

        if($user->user_type == 'normal' && $tickets->user_id != $user->id){ //Caso o usuário comum tente abrir um ticket que não é dele retorna para a tela index
            return redirect()
            ->route('index')
            ->with('message', 'Você não tem permissão para visualizar este ticket');
        }

        if($tickets->responsable_id){
            $responsavel = User::find($tickets->responsable_id);
        }
        else{
            $responsavel = null;
        }


        return view('user.tickets.detail', compact('tickets', 'responsavel', 'user'));
    }

    public function apropriar($id)
    {
        $user = auth()->user();

        if (!$tickets = Tickets::find($id)){
            return redirect()
            ->route('index')
            ->with('message', 'Ticket não localizado');
        };

        if($user->user_type == 'normal' && $tickets->user_id != $user->id){ //Caso o usuário comum tente abrir um ticket que não é dele retorna para a tela index
            return redirect()
            ->route('index')
            ->with('message', 'Acesso não permitido');
        }

        Tickets::where('id', $id)
        ->update(['responsable_id' => $user->id]);

        $tickets = Tickets::find($id);

        if($tickets->responsable_id){
            $responsavel = User::find($tickets->responsable_id);
        }
        else{
            $responsavel = null;
        }

        return view('user.tickets.detail', compact('tickets', 'responsavel', 'user'));
    }

    public function encerrar(CloseTicket $request, $id)
    {
        $user = auth()->user();

        if (!$tickets = Tickets::find($id)){
            return redirect()
            ->route('index')
            ->with('message', 'Ticket não localizado');
        };

        $horaAtual = Carbon::now();

        Tickets::where('id', $id)
        ->update([
            'closed_at' => $horaAtual,
            'closure_reason' => $request->closure_reason,
        ]);

        $tickets = Tickets::find($id);

        if($tickets->responsable_id){
            $responsavel = User::find($tickets->responsable_id);
        }
        else{
            $responsavel = null;
        }

        return view('user.tickets.detail', compact('tickets', 'responsavel', 'user'));
    }
}
