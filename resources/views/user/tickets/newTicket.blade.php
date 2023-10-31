<h1>Abertura de Tickets</h1>
<form action="{{ route('user.tickets.store') }}" method="post">
    @csrf
    <input type="text" name="title" id="title" placeholder="Título">
    <textarea name="description" id="description" cols="30" rows="10" placeholder="Descricao"></textarea>
    <input type="text" name="type" id="type" placeholder="Tipo">
    <button type="submit">Abrir ticket</button>
</form>
