<h1>Todas as Solicitações</h1>

@foreach ($tickets as $ticket)
    <p>Protocolo: {{ $ticket->protocol }}</p>
    <p>Título: {{ $ticket->title }}</p>
    <p>Descrição: {{ $ticket->description }}</p>
    <br>
@endforeach
