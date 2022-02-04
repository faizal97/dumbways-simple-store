<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'id' => Str::orderedUuid(),
            'name' => 'Admin',
            "email" => 'admin@store.com',
            "password" => Hash::make('admin'),
            "role" => 'admin'
        ]);
        User::factory()->create([
            'id' => Str::orderedUuid(),
            'name' => 'User',
            "email" => 'user@store.com',
            "password" => Hash::make('user'),
            "role" => 'user',
        ]);
    }
}
