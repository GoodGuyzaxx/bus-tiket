<?php

namespace Database\Seeders;

use App\Models\Passenger;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

        DB::table('passengers')->insert([
            'name' => 'Dewantra',
            'email' => 'drawww111@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '082266699447'
        ]);
    }
}
