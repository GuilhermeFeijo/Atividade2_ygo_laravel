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

            $users = User::paginate(5);

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
}
