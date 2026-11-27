<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deposit extends Model
{
    protected $table = 'deposits';

    protected $guarded = [];

    // Tabel hanya punya created_at.
    const UPDATED_AT = null;

    protected $casts = [
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
