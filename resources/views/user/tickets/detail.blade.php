@extends('layouts.app')

@section('title', 'Detalhes')

@section('content')

    <h1>Detalhes do Ticket {{ $tickets->protocol }}</h1>

    <ul>
        <li>Tipo: {{ $tickets->type }}</li>
        <li>Protocolo: {{ $tickets->protocol }}</li>
        <li>Título: {{ $tickets->title }}</li>
        <li>Descrição: {{ $tickets->description }}</li>
        <li>Data de abertura: {{ date( 'd/m/Y' , strtotime($tickets->open_at)) }}</li>
        @if ($responsavel)

            <li>Responsável: {{ $responsavel->name }}</li>

            @if ($responsavel->id != $user->id)

                <form action="{{ route('tickets.appropriate', [$tickets->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <button type="submit">Apropriar</button>
                </form>

            @endif

        @else

            <li>Responsável: Aguardando atendente</li>

            @if ($user->user_type == 'superadmin' || $user->user_type == 'responsable')

                <form action="{{ route('tickets.appropriate', [$tickets->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <button type="submit">Apropriar</button>
                </form>

            @endif

        @endif

        @if ($tickets->closed_at == null)

            <li>Status: Aberto</li>

            <form action="{{ route('tickets.finish', [$tickets->id]) }}" method="post">
                @csrf
                @method('PUT')
                <textarea name="closure_reason" id="closure_reason" cols="30" rows="10" placeholder="Motivo do Encerramento"></textarea>
                <button type="submit">Encerrar</button>
            </form>
        @else

            <li>Status: Encerrado</li>
            <li>Motivo do Encerramento: {{ $tickets->closure_reason }}</li>

        @endif



    </ul>




@endsection
