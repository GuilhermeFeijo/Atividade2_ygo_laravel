@extends('layouts.app')

@section('title', 'Tela inicial')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="text-center">Solicitações</h1>
    </div>


    @if ($user->user_type == 'normal')
        <div class="col-lg-12">
            <a href="{{ route('tickets.newTicket') }}">Abrir um novo Ticket</a>
        </div>
    @endif

    @if (session('message'))
    <div>
        {{ session('message') }}
    </div>
    @endif

    @foreach ($tickets as $ticket)
    <div class="col-lg-3">
        <div class="card">
            <div class="card-header">
                <p>Título: {{ $ticket->title }}</p>
            </div>
            <div class="card-body">
                <p><a href="{{ route('tickets.detail', [$ticket->id]) }}">Protocolo: {{ $ticket->protocol }}</a></p>
                <p>Tipo: {{ $ticket->type }}</p>
                @if ($ticket->closed_at == null)
                    <p>Status: Aberto</p>
                @else
                    <p>Status: Encerrado</p>
                @endif
            </div>
        </div>
    </div>

    @endforeach

    <hr>


    @if ($user->user_type == 'superadmin')
        @include('_partials.adminFooter')
    @else
        @include('_partials.userFooter')
    @endif
</div>


@endsection
