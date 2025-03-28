<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RawMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'price',
        'stock',
        'description'
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

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }

    public function outflows(): HasMany
    {
        return $this->hasMany(Outflow::class);
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

    public function scopeFilter(Builder $query, array $filters)
    {
        if (isset($filters['search'])) {
            $query->where(function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('price', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('stock', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }
    }
}
