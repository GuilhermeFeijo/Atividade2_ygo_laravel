<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    ////////////////////////////////////////
    ///////// FUNÇÕES NATIVAS //////////////
    ////////////////////////////////////////

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => '1',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    ////////////////////////////////////////
    ///////// FUNÇÕES CRIADAS //////////////
    ////////////////////////////////////////

    public function index()
    {
        $user = auth()->user(); //Coleta as informações do usuário logado

        if($user->user_type == 'superadmin'){

            $users = User::paginate(3);

        }else{

            return redirect()
            ->route('index')
            ->with('message', 'Você não tem permissão para visualizar este ticket');

        }

        return view('admin.users.index', compact('users')); //compact -> passa um array com tudo que contém no tickets
    }

    public function cadastro()
    {
        return view('admin.users.userCreate');
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => '1',
        ]);

        event(new Registered($user));

        return redirect()->route('user.index');
    }

    public function desativar($id)
    {
        $user = auth()->user();

        if($user->id == $id){
            return redirect()
            ->route('user.index')
            ->with('message', 'Você não pode desativar o próprio usuário ¯\_(ツ)_/¯');
        }

        if (!User::find($id)){
            return redirect()
            ->route('user.index')
            ->with('message', 'Usuário não localizado');
        }

        if($user->user_type != 'superadmin'){
            return redirect()
            ->route('index')
            ->with('message', 'Acesso não permitido');
        }

        User::where('id', $id)
        ->update(['status' => 0]);

        return redirect()->route('user.index');
    }

    public function ativar($id)
    {
        $user = auth()->user();

        if (!User::find($id)){
            return redirect()
            ->route('user.index')
            ->with('message', 'Usuário não localizado');
        }

        if($user->user_type != 'superadmin'){
            return redirect()
            ->route('index')
            ->with('message', 'Acesso não permitido');
        }

        User::where('id', $id)
        ->update(['status' => 1]);

        return redirect()->route('user.index');
    }

    public function permissao(Request $request, $id)
    {
        $user = auth()->user();

        if($user->id == $id){
            return redirect()
            ->route('user.index')
            ->with('message', 'Você não pode mudar a permissão do próprio usuário (ㆆ_ㆆ)');
        }

        if (!User::find($id)){
            return redirect()
            ->route('user.index')
            ->with('message', 'Usuário não localizado');
        }

        if($user->user_type != 'superadmin'){
            return redirect()
            ->route('index')
            ->with('message', 'Acesso não permitido');
        }

        User::where('id', $id)
        ->update(['user_type' => $request->user_type]);

        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
        $user = auth()->user();

        if($user->id == $id){
            return redirect()
            ->route('user.index')
            ->with('message', 'Você não pode excluir o próprio usuário (ㆆ_ㆆ)');
        }

        if (!$users = User::find($id)){
            return redirect()
            ->route('user.index')
            ->with('message', 'Usuário não localizado');
        }

        if($user->user_type != 'superadmin'){
            return redirect()
            ->route('index')
            ->with('message', 'Acesso não permitido');
        }

        $users->delete();

        return redirect()->route('user.index');
    }
}
