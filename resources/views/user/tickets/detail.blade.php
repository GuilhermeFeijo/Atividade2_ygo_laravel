@extends('layouts.app')

@section('title', 'Detalhes')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="text-center">Detalhes do Protocolo {{ $tickets->protocol }}</h1>
    </div>

    <div class="col-lg-12">
        <div class="rounded border border-secondary">
            <div class="px-2">
                <h2>Título: {{ $tickets->title }}</h2>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="rounded border border-secondary">
            <div class="px-2">
                <p>Tipo: {{ $tickets->type }}</p>
            </div>
        </div>
        <div class="rounded border border-secondary">
            <div class="px-2">
                <p>Descrição: {{ $tickets->description }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="rounded border border-secondary">
            <div class="px-2">
                <p>Protocolo: {{ $tickets->protocol }}</p>
            </div>
        </div>
        <div class="rounded border border-secondary">
            <div class="px-2">
                @if ($tickets->closed_at == null)
                    <p>Status: Aberto</p>
                @else
                    <p>Status: Encerrado</p>
                    <p>Motivo do Encerramento: {{ $tickets->closure_reason }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="rounded border border-secondary">
            <div class="px-2">
                <p>Data de abertura: {{ date( 'd/m/Y' , strtotime($tickets->open_at)) }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="rounded border border-secondary">
            <div class="px-2">
                @if ($responsavel)
                    <p>Responsável: {{ $responsavel->name }}</p>
                @else
                    <p>Responsável: Aguardando atendente</p>
                @endif
            </div>
        </div>
    </div>

    @if ($responsavel)

        @if ($responsavel->id != $user->id)

            <form action="{{ route('tickets.appropriate', [$tickets->id]) }}" method="post">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-success">Apropriar</button>
            </form>

        @endif

    @else

        @if ($user->user_type == 'superadmin' || $user->user_type == 'responsable')

            <form action="{{ route('tickets.appropriate', [$tickets->id]) }}" method="post">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-success">Apropriar</button>
            </form>

        @endif

    @endif


    @if ($tickets->closed_at == null)

        <form action="{{ route('tickets.finish', [$tickets->id]) }}" method="post">
            @csrf
            @method('PUT')
            <textarea name="closure_reason" id="closure_reason" cols="30" rows="10" placeholder="Motivo do Encerramento"></textarea>
            <br>
            <button type="submit" class="btn btn-danger">Encerrar</button>
        </form>
    @endif

    </div>
</div>
<div class="row">
    @if ($user->user_type == 'superadmin')
        @include('_partials.adminFooter')
    @else
        @include('_partials.userFooter')
    @endif
</div>






@endsection
