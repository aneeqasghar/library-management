<?php

namespace App\Models;

use App\Enums\User as UserStatus;
use App\Events\UserRestored;
use App\Events\UserSoftDeleted;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use SoftDeletes;
    use HasApiTokens;

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

    protected static function booted()
    {
        static::deleting(function (User $user) {
            if (! $user->isForceDeleting()) {
                event(new UserSoftDeleted($user));
            }
        });

        static::restoring(function (User $user) {
            event(new UserRestored($user));
        });
    }

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
        return $this->morphToMany(Role::class, 'roleable');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_users')
                    ->withPivot(['borrow_at', 'due_at', 'return_at', 'status']);
    }

    // public function hasRole(string $role)
    // {
    //     return $this->roles()->where('name', $role)->exists();
    // }

    // public function canAccessPanel(Panel $panel): bool
    // {
    //     return $this->hasRole('admin');
    // }
}
