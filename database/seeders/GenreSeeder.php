<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        Genre::create(['nama_genre' => 'Action']);
        Genre::create(['nama_genre' => 'Horror']);
        Genre::create(['nama_genre' => 'Comedy']);
        Genre::create(['nama_genre' => 'Drama']);
    }
}
