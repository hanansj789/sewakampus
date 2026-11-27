<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Handover extends Model
{
    protected $table = 'handovers';

    protected $guarded = [];

    // Tabel hanya punya created_at.
    const UPDATED_AT = null;

    protected $casts = [
        'renter_confirmed_at' => 'datetime',
        'owner_confirmed_at' => 'datetime',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function confirmedByBothParties(): bool
    {
        return $this->renter_confirmed_at !== null && $this->owner_confirmed_at !== null;
    }
}
