@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Tickets Pendientes</h2>

    <!-- Mensaje de éxito si el ticket se actualiza -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabla de tickets pendientes o asignados al técnico -->
    <div class="overflow-x-auto mt-4">
        <table class="table-auto w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Asunto</th>
                    <th class="py-3 px-6 text-left">Descripción</th>
                    <th class="py-3 px-6 text-left">Cliente</th>
                    <th class="py-3 px-6 text-center">Estado</th>
                    <th class="py-3 px-6 text-center">Responder</th>
                    <th class="py-3 px-6 text-center">Cerrar Ticket</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($tickets as $ticket)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $ticket->id }}</td>
                        <td class="py-3 px-6">{{ $ticket->subject }}</td>
                        <td class="py-3 px-6">{{ $ticket->description }}</td>
                        <td class="py-3 px-6">{{ $ticket->user->name }}</td>
                        <td class="py-3 px-6 text-center">{{ ucfirst($ticket->status) }}</td>

                        <!-- Formulario para responder al ticket -->
                        <td class="py-3 px-6 text-center">
                            <form action="{{ route('messages.store', $ticket->id) }}" method="POST">
                                @csrf
                                <textarea name="message" class="form-input border-gray-300 rounded w-full" rows="2" placeholder="Escriba una respuesta..." required></textarea>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded mt-2">
                                    Enviar Respuesta
                                </button>
                            </form>
                        </td>

                        <!-- Botón para cerrar el ticket -->
                        <td class="py-3 px-6 text-center">
                            @if($ticket->status !== 'cerrado')
                                <form action="{{ route('tickets.close', $ticket->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                        Cerrar Ticket
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-500">Cerrado</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
