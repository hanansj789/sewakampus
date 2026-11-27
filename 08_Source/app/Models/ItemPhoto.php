<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemPhoto extends Model
{
    protected $table = 'item_photos';

    protected $guarded = [];

    // Tabel hanya punya created_at.
    const UPDATED_AT = null;

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
