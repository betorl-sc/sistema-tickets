@extends('layouts.app')

@section('content')
<h1>Mis Tickets</h1>
@foreach ($tickets as $ticket)
    <a href="{{ route('tickets.show', $ticket->id) }}">
        <h2>{{ $ticket->title }}</h2>
        <p>{{ $ticket->status }}</p>
    </a>
@endforeach
@endsection
