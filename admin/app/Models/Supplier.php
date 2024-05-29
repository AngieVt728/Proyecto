<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Supplier extends Model
{
    use HasFactory;

    protected  $fillable = [
        'name',
        'nit',
        'email',
        'phone_number',
        'address',
        'description'
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

    public function scopeFilter(Builder $query, array $filters)
    {
        if (isset($filters['search'])) {
            $query->where(function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['search'] . '%')
                    ->where('nit', 'like', '%' . $filters['search'] . '%')
                    ->where('email', 'like', '%' . $filters['search'] . '%')
                    ->where('phone_number', 'like', '%' . $filters['search'] . '%');
            });
        }
    }
}
