<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RawMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock'
    ];

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(
            Supplier::class,
            'raw_material_supplier',
            'raw_material_id',
            'supplier_id'
        )->withTimestamps();
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_raw_material',
            'product_id',
            'raw_material_id'
        )->withTimestamps();
    }

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }

    public function outflows(): HasMany
    {
        return $this->hasMany(Outflow::class);
    }
}
