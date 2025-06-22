<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GenreSeeder::class,
            StudioSeeder::class,
            AdminUserSeeder::class,
            FilmSeeder::class,
            JadwalTayangSeeder::class,
        ]);
    }
}
