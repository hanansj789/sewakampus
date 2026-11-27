<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingStatusHistory extends Model
{
    protected $table = 'booking_status_histories';

    protected $guarded = [];

    // Tabel hanya punya created_at.
    const UPDATED_AT = null;

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
