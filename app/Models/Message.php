<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id', 'user_id', 'message'
    ];

    // Relación: Un mensaje pertenece a un ticket
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    // Relación: Un mensaje pertenece a un usuario (quien lo envió)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
