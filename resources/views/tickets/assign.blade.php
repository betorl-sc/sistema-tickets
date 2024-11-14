@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Asignar Ticket a Técnico</h2>

    <!-- Mostrar un mensaje de éxito si el ticket fue asignado -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Listado de tickets pendientes de asignar -->
    <div class="overflow-x-auto mt-4">
        <table class="table-auto w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Asunto</th>
                    <th class="py-3 px-6 text-left">Descripción</th>
                    <th class="py-3 px-6 text-left">Cliente</th>
                    <th class="py-3 px-6 text-center">Asignar a Técnico</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($tickets as $ticket)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $ticket->id }}</td>
                        <td class="py-3 px-6">{{ $ticket->subject }}</td>
                        <td class="py-3 px-6">{{ $ticket->description }}</td>
                        <td class="py-3 px-6">{{ $ticket->user->name }}</td>
                        <td class="py-3 px-6 text-center">
                            <form action="{{ route('tickets.assign', $ticket->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="technician_id" class="form-select border-gray-300 rounded" required>
                                    <option value="">Seleccionar Técnico</option>
                                    @foreach($technicians as $technician)
                                        <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">
                                    Asignar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
