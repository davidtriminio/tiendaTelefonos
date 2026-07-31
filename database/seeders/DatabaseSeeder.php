<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'Triminio',
            'email' => 'triminio@ae.com',
            'password' => \Hash::make('admin'),
            'email_verified_at' => now(),
        ]);
    }
}
