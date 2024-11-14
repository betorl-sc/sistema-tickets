@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalles del Ticket</h2>

    <!-- Detalles del Ticket -->
    <div class="card my-4">
        <div class="card-header">
            <strong>Asunto:</strong> {{ $ticket->subject }}
        </div>
        <div class="card-body">
            <p><strong>Descripción:</strong> {{ $ticket->description }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($ticket->status) }}</p>
            <p><strong>Asignado a:</strong> {{ $ticket->technician ? $ticket->technician->name : 'No asignado' }}</p>
        </div>
    </div>

    <!-- Historial de Mensajes -->
    <h3>Historial de Mensajes</h3>
    <div class="list-group my-3">
        @foreach($messages as $message)
            <div class="list-group-item">
                <p><strong>{{ $message->user->name }}:</strong></p>
                <p>{{ $message->message }}</p>
                <small class="text-muted">{{ $message->created_at->format('d/m/Y H:i') }}</small>
            </div>
        @endforeach
    </div>

    <!-- Formulario para Enviar un Mensaje -->
    <h3>Enviar un Mensaje</h3>
    <form action="{{ route('messages.store', $ticket->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <textarea name="message" class="form-control" rows="3" placeholder="Escribe tu mensaje aquí..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Enviar Mensaje</button>
    </form>
</div>
@endsection
