<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar_url',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Filament Panel access control based on user role.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($panel->getId() === 'admin') {
            return in_array($this->role, [
                'super_admin',
                'director',
                'finance',
                'sales',
                'product_admin',
                'project_manager',
                'academy_admin',
                'developer',
            ], true);
        }

        if ($panel->getId() === 'portal') {
            return true; // All authenticated active users (customers & staff) can access customer portal
        }

        return false;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isDirector(): bool
    {
        return in_array($this->role, ['super_admin', 'director'], true);
    }

    public function isFinance(): bool
    {
        return in_array($this->role, ['super_admin', 'director', 'finance'], true);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
}
