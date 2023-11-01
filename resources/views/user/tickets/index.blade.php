@if ($user->user_type == 'normal')
    <a href="{{ route('tickets.newTicket') }}">Abrir um novo Ticket</a>
@endif
<h1>Solicitações</h1>

@if (session('message'))
    <div>
        {{ session('message') }}
    </div>
@endif

@foreach ($tickets as $ticket)
    <p><a href="{{ route('tickets.detail', [$ticket->id]) }}">Protocolo: {{ $ticket->protocol }}</a></p>
    <p>Título: {{ $ticket->title }}</p>
    <p>Tipo: {{ $ticket->type }}</p>
    @if ($ticket->closed_at == null)
        <p>Status: Aberto</p>
    @else
        <p>Status: Encerrado</p>
    @endif
    <br>
@endforeach

<hr>

{{ $tickets->links() }}
