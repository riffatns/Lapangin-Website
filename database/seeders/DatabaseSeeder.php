<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SportsSeeder::class,
            UserProfilesSeeder::class,
            VenuesSeeder::class,
            CommunitiesSeeder::class,
            BookingsSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
