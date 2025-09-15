<?php

namespace Database\Seeders;

use App\Enums\Role as RoleName;
use App\Models\Admin;
use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        $roles = Role::insert([
        ['name' => RoleName::FULL_ACCESS],
        ['name' => RoleName::MEMBER],
        ]);

        $admin = Admin::factory()->create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
         ]);
        $admin->roles()->attach(Role::where('name', RoleName::FULL_ACCESS)->first()->id);

        User::factory(50)->create()->each(function ($user) {
            $user->roles()->attach(
                Role::where('name', RoleName::MEMBER)->first()->id
            );
        });


    }
}
