@extends('layouts.app')

@section('title', 'Dominios')

@section('content')

    <h1>Cadastro de Domínios</h1>

    @if ($errors->any())
    <ul>
        @foreach ($errors as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <form action="{{ route('domains.store') }}" method="post">
        @csrf
        <input type="text" name="name" id="name" placeholder="Nome" value="{{ old('name') }}">
        <input type="text" name="domain" id="domain" placeholder="Domínio" value="{{ old('domain') }}">
        <button type="submit">Cadastrar Domínio</button>
    </form>

    @if ($user->user_type == 'superadmin')
        @include('_partials.adminFooter')
    @else
        @include('_partials.userFooter')
    @endif

@endsection
