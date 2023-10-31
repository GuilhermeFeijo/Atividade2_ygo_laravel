<a href="{{ route('user.tickets.newTicket') }}">Abrir um novo Ticket</a>
<h1>Suas Solicitações</h1>

@foreach ($tickets as $ticket)
    <p>Protocolo: {{ $ticket->protocol }}</p>
    <p>Título: {{ $ticket->title }}</p>
    <p>Descrição: {{ $ticket->description }}</p>
@endforeach
