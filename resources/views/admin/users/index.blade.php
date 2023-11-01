@extends('layouts.app')

@section('title', 'Usuários')

@section('content')

    <h1>Usuários</h1>

    @if (session('message'))
        <div>
            {{ session('message') }}
        </div>
    @endif

    <form action="{{ route('user.register') }}" method="get">
        @csrf
        <button type="submit">Cadastrar usuário</button>
    </form>
    <br>

    @foreach ($users as $user)
        <p>ID: {{ $user->id }}</a></p>
        <p>Nome: {{ $user->name }}</p>
        <p>E-Mail: {{ $user->email }}</p>
        <p>Tipo: {{ $user->user_type }}</p>
        <p>Status: 1-Ativo 0-Inativo: {{ $user->status }}</p>
        <p>Data de criação: {{ date( 'd/m/Y' , strtotime($user->created_at)) }}</p>
        @if ($user->status == 1)
            <form action="{{ route('user.deactivate', [$user->id]) }}" method="post">
                @csrf
                @method('PUT')
                <button type="submit">Desativar usuário</button>
            </form>
        @else
            <form action="{{ route('user.activate', [$user->id]) }}" method="post">
                @csrf
                @method('PUT')
                <button type="submit">Ativar usuário</button>
            </form>
        @endif
        <form action="{{ route('user.permission', [$user->id]) }}" method="post">
            @csrf
            @method('PUT')
            Mudar permissão:
            <select name="user_type" id="user_type">
                <option value="normal">normal</option>
                <option value="responsable">responsable</option>
                <option value="superadmin">superadmin</option>
            </select>
            <button type="submit">Alterar</button>
        </form>
        <form action="{{ route('user.delete', [$user->id]) }}" method="post">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit">Excluir usuário</button>
        </form>

        <br>
    @endforeach

    <hr>

    {{ $users->links() }}


    @include('_partials.adminFooter')


@endsection
