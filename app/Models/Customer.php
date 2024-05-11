<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'ci',
        'email',
        'password',
        'phone_number',
        'address',
    ];

    public function retailOutlets(): HasMany
    {
        return $this->hasMany(RetailOutlet::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
