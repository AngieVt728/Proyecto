<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected  $fillable = [
        'name',
        'nit',
        'description',
        'email',
        'phone_number',
        'address'
    ];

    public function raw_materials()
    {
        return $this->belongsToMany(RawMaterial::class);
    }
}
