<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $guarded = ['*'];

    protected $hidden = ['password_hash'];

    public function verification(): HasOne
    {
        return $this->hasOne(StudentVerification::class)
            ->where('status', 'APPROVED')
            ->latestOfMany();
    }

    public function maskedNim(): ?string
    {
        $nim = $this->verification?->nim;

        return $nim ? '******'.substr($nim, -4) : null;
    }
}
