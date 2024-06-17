<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'ci',
        'contact',
        'address',
        'username',
        'email',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function generateUsername($firstName, $lastName)
    {
        $firstName = strtolower($firstName);
        $lastName = strtolower($lastName);

        $baseUsername = substr($firstName, 0, 1) . $lastName;

        $username = $baseUsername;
        $counter = 1;

        while (self::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }

    public function retailOutlets(): HasMany
    {
        return $this->hasMany(RetailOutlet::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        if (isset($filters['search'])) {
            $query->where(function ($query) use ($filters) {
                $query->where('first_name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('last_name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('email', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('ci', 'like', '%' . $filters['search'] . '%');
            });
        }
    }
}
