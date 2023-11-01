@extends('layouts.app')

@section('title', 'Abertura')

@section('content')

    <h1>Abertura de Tickets</h1>

    @if ($errors->any())
    <ul>
        @foreach ($errors as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <form action="{{ route('tickets.store') }}" method="post">
        @csrf
        <input type="text" name="title" id="title" placeholder="Título" value="{{ old('title') }}">
        <textarea name="description" id="description" cols="30" rows="10" placeholder="Descricao" value="{{ old('description') }}"></textarea>
        <input type="text" name="type" id="type" placeholder="Tipo" value="{{ old('type') }}">
        <button type="submit">Abrir ticket</button>
    </form>


@endsection
