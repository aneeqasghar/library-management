<?php

namespace App\Models;

use App\Enums\Role as RoleName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name'];

    protected $casts = [
        'name' => RoleName::class,
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
