<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Event.php
class Event extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'start_at',
        'end_at',
        'all_day',
        'notes',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
        'all_day'  => 'boolean',
    ];
}
