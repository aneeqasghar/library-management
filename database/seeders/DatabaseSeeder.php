<?php

namespace Database\Seeders;

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
        ['name' => 'admin'],
        ['name' => 'member'],
        ]);

        $admin = User::factory()->create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
         ]);
        $admin->roles()->attach(Role::where('name', 'admin')->first()->id);

        User::factory(50)->create()->each(function ($user) {
        $user->roles()->attach(
            Role::where('name', 'member')->first()->id
        );
        });


    }
}
