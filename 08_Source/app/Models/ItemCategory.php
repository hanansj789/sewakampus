<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    protected $table = 'item_categories';

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
