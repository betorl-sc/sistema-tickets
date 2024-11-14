<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('tickets', TicketController::class)->except(['edit', 'update', 'destroy']);
    Route::post('tickets/{ticket}/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('tickets/{ticket}/assign', [TicketController::class, 'assign'])->name('tickets.assign');
    Route::get('tickets/pending', [TicketController::class, 'pending'])->name('tickets.pending');

    Route::patch('tickets/{ticket}/close', [TicketController::class, 'closeTicket'])->name('tickets.close');
});
require __DIR__.'/auth.php';
