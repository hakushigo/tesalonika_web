<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\BAAK::insert([
            ["username" => "frieren", "password" => Hash::make("example123") ],
            ["username" => "frieren1", "password" => Hash::make("example123") ],
            ["username" => "frieren2", "password" => Hash::make("example123") ],
        ]);
    }
}
