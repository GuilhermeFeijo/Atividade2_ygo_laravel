<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateDomain;
use App\Models\Domains;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DomainsController extends Controller
{
    public function index()
    {
        $user = auth()->user(); //Coleta as informações do usuário logado

        if($user->user_type == 'superadmin' || $user->user_type == 'responsable'){ //Se for admin entra na tela de todos os domains

            $domains = Domains::orderBy('id', 'DESC')->get(); //Coleta do banco todos os campos do ticket

        }else{

            return redirect()
            ->route('index')
            ->with('message', 'Acesso não permitido');

        }

        return view('admin.domains.index', compact('domains', 'user')); //compact -> passa um array com tudo que contém no domains
    }

    public function cadastro()
    {
        $user = auth()->user(); //Coleta as informações do usuário logado
        if($user->user_type == 'superadmin' || $user->user_type == 'responsable'){
        }else{
            return redirect()
            ->route('index')
            ->with('message', 'Acesso não permitido');
        }

        return view('admin.domains.create', compact('user')); //compact -> passa um array com tudo que contém no domains
    }


    public function store(StoreUpdateDomain $request)
    {
        $user_id = auth()->user()->id;
        $requestData = $request->all();
        $requestData['created_by'] = $user_id;

        $horaAtual = Carbon::now();
        $requestData['created_at'] = $horaAtual;

        $requestData['status'] = 1;
        Domains::create($requestData);

        return redirect()->route('domains.index');
    }

    public function desativar($id)
    {
        $user = auth()->user();

        if (!Domains::find($id)){
            return redirect()
            ->route('user.index')
            ->with('message', 'Domínio não localizado');
        }

        if($user->user_type == 'normal'){
            return redirect()
            ->route('index')
            ->with('message', 'Acesso não permitido');
        }

        Domains::where('id', $id)
        ->update(['status' => 0]);

        return redirect()->route('domains.index');
    }

    public function ativar($id)
    {
        $user = auth()->user();

        if (!Domains::find($id)){
            return redirect()
            ->route('user.index')
            ->with('message', 'Domínio não localizado');
        }

        if($user->user_type == 'normal'){
            return redirect()
            ->route('index')
            ->with('message', 'Acesso não permitido');
        }

        Domains::where('id', $id)
        ->update(['status' => 1]);

        return redirect()->route('domains.index');
    }

    public function destroy($id)
    {
        $user = auth()->user();

        if (!$domain = Domains::find($id)){
            return redirect()
            ->route('user.index')
            ->with('message', 'Domínio não localizado');
        }

        if($user->user_type == 'normal'){
            return redirect()
            ->route('index')
            ->with('message', 'Acesso não permitido');
        }

        $domain->delete();

        return redirect()->route('domains.index');
    }
}
