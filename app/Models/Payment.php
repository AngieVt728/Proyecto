<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'detail',
        'payment_date',
        'payment_balance',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        if (isset($filters['search'])) {
            $query->where(function ($query) use ($filters) {
                $query->where('detail', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('payment_date', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('payment_balance', 'like', '%' . $filters['search'] . '%');
            });
        }
    }
}
