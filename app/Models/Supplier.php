<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function rawMaterials(): BelongsToMany
    {
        return $this->belongsToMany(
            RawMaterial::class,
            'raw_material_supplier',
            'raw_material_id',
            'supplier_id'
        )->withTimestamps();
    }
}
