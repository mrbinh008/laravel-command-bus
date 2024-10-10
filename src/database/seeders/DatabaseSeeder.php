<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Infrastructure\Database\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(30)->create();

//        User::factory(30)->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//            'password' => bcrypt('password'),
//        ]);
    }
}
