<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id', // Asegúrate de incluir este campo
        'technician_id',
    ];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación: Un ticket puede estar asignado a un técnico (user)
    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    // Relación: Un ticket puede tener varios mensajes
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'ticket_id');
    }
}
