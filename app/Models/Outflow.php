<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Outflow extends Model
{
    use HasFactory;

    protected $fillable = [
        'outflow_date',
        'quantity'
    ];

    public function rawMaterial(): BelongsTo
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function outflows(): HasMany
    {
        return $this->hasMany(Outflow::class);
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        if (isset($filters['search'])) {
            $query->where(function ($query) use ($filters) {
                $query->where('outflow_date', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('quantity', 'like', '%' . $filters['search'] . '%');
            });
        }
    }
}
