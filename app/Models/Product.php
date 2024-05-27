<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock'
    ];

    public function rawMaterials(): BelongsToMany
    {
        return $this->belongsToMany(
            RawMaterial::class,
            'product_raw_material',
            'product_id',
            'raw_material_id'
        )->withTimestamps();
    }

    public function sale(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function revenue(): HasMany
    {
        return $this->hasMany(Revenue::class);
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        if (isset($filters['search'])) {
            $query->where(function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['search'] . '%');
            });
        }
    }
}
