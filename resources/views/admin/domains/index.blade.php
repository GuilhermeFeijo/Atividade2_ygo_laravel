@extends('layouts.app')

@section('title', 'Domínios')

@section('content')

    <h1>Domínios</h1>

    @if (session('message'))
        <div>
            {{ session('message') }}
        </div>
    @endif

    <form action="{{ route('domains.newDomain') }}" method="get">
        @csrf
        <button type="submit">Cadastrar Domínio</button>
    </form>
    <br>

    @foreach ($domains as $domain)
        <p>ID: {{ $domain->id }}</a></p>
        <p>Nome: {{ $domain->name }}</p>
        <p>E-Mail: {{ $domain->domain }}</p>
        <p>Status: 1-Ativo 0-Inativo: {{ $domain->status }}</p>
        <p>Data de criação: {{ date( 'd/m/Y' , strtotime($domain->created_at)) }}</p>
        @if ($domain->status == 1)
            <form action="{{ route('domain.deactivate', [$domain->id]) }}" method="post">
                @csrf
                @method('PUT')
                <button type="submit">Desativar Domínio</button>
            </form>
        @else
            <form action="{{ route('domain.activate', [$domain->id]) }}" method="post">
                @csrf
                @method('PUT')
                <button type="submit">Ativar Domínio</button>
            </form>
        @endif
        <form action="{{ route('domain.delete', [$domain->id]) }}" method="post">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit">Excluir Domínio</button>
        </form>


        <br>
    @endforeach

    <hr>

    {{ $domains->links() }}


    @if ($user->user_type == 'superadmin')
        @include('_partials.adminFooter')
    @else
        @include('_partials.userFooter')
    @endif


@endsection
