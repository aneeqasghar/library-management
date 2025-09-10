<?php

namespace App\Models;

use App\Enums\User as UserStatus;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => UserStatus::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_user')
                    ->withPivot(['borrow_at', 'due_at', 'return_at', 'status']);
    }

    public function hasRole(string $role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('admin');
    }
}
