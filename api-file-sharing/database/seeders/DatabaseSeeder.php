<?php

namespace Database\Seeders;

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
        User::factory()->create([
            'email' => 'test@gmail.com',
            'first_name' => 'First',
            'last_name' => 'Tester',
            'password' => Hash::make('test'),
        ]);

        User::factory()->create([
            'email' => 'test2@gmail.com',
            'first_name' => 'Second',
            'last_name' => 'Tester',
            'password' => Hash::make('test'),
        ]);
    }
}
