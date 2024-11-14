<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'cliente') {
            $tickets = Ticket::where('user_id', $user->id)->get();
        } else {
            $tickets = Ticket::where('status', 'pendiente')->orWhere('technician_id', $user->id)->get();
        }
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Ticket::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pendiente',
        ]);

        return redirect()->route('tickets.index');
    }

    public function show(Ticket $ticket)
    {
        $messages = $ticket->messages;
        return view('tickets.show', compact('ticket', 'messages'));
    }



    public function assign(Request $request, Ticket $ticket)
    {
        $request->validate([
            'technician_id' => 'required|exists:users,id',
        ]);

        $ticket->update([
            'technician_id' => $request->technician_id,
            'status' => 'asignado',
        ]);

        return redirect()->route('tickets.pending')->with('success', 'Ticket asignado exitosamente.');
    }

    public function closeTicket(Ticket $ticket)
{
    // Solo el técnico puede cerrar el ticket
    if (Auth::user()->role !== 'tecnico') {
        abort(403, 'No autorizado');
    }

    $ticket->update([
        'status' => 'cerrado',
    ]);

    return redirect()->route('tickets.pending')->with('success', 'Ticket cerrado exitosamente.');
}
/*
public function pending()
{


    // Verifica que el usuario sea un técnico antes de ver los tickets pendientes
    if (Auth::user()->role !== 'tecnico') {
        abort(403, 'No autorizado');
    }

    // Obtiene los tickets pendientes o asignados
    $tickets = Ticket::whereIn('status', ['pendiente', 'asignado'])->get();

    // Retorna la vista 'tickets.pending' con los tickets como datos
    return view('tickets.pending', compact('tickets'));
} */
public function pending()
{
    try {
        // Verifica que el usuario sea un técnico antes de ver los tickets pendientes
        if (Auth::user()->role !== 'tecnico') {
            abort(403, 'No autorizado');
        }

        // Obtiene los tickets con estado "pendiente" o "asignado"
        $tickets = Ticket::whereIn('status', ['pendiente', 'asignado'])->get();

        // Retorna la vista 'tickets.pending' con los tickets como datos
        return view('tickets.pending', compact('tickets'));
    } catch (\Exception $e) {
        // Registra el error y redirige con un mensaje de error al usuario
        \Log::error("Error al cargar tickets pendientes: " . $e->getMessage());

        // Redirige al usuario a la página anterior con un mensaje de error
        return redirect()->back()->with('error', 'Hubo un problema al cargar los tickets pendientes. Intente nuevamente más tarde.');
    }
}

}
