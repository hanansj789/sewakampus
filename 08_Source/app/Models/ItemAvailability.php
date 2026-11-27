<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemAvailability extends Model
{
    protected $table = 'item_availabilities';

    protected $guarded = [];

    // Tabel hanya punya created_at.
    const UPDATED_AT = null;

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
