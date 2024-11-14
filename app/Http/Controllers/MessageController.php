<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Almacena un nuevo mensaje para un ticket específico
    public function store(Request $request, Ticket $ticket)
    {
        // Verifica que el usuario tenga acceso al ticket (cliente o técnico asignado)
        if (
            Auth::user()->role == 'cliente' && $ticket->user_id != Auth::id() ||
            Auth::user()->role == 'tecnico' && $ticket->technician_id != Auth::id()
        ) {
            abort(403, 'No autorizado');
        }

        // Valida el mensaje
        $request->validate([
            'message' => 'required|string',
        ]);

        // Crea el mensaje en la base de datos
        Message::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Mensaje enviado con éxito.');
    }
}
