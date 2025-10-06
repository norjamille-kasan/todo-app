<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class
        ]);

        User::create([
            'name' => 'Norjamille Kasan',
            'email' => 'norjamille@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);

        Todo::factory(200)->create();
    }
}
