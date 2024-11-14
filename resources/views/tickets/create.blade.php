@extends('layouts.app')

@section('content')
<h1>Crear Ticket</h1>
<form action="{{ route('tickets.store') }}" method="POST">
    @csrf
    <label>Título</label>
    <input type="text" name="title">
    <label>Descripción</label>
    <textarea name="description"></textarea>
    <button type="submit">Crear Ticket</button>
</form>
@endsection
