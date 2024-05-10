<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock'
    ];

    public function raw_materials(): BelongsToMany
    {
        return $this->belongsToMany(
            RawMaterial::class,
            'product_raw_material',
            'product_id',
            'raw_material_id'
        )->withTimestamps();
    }
}
