<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Film;
use App\Models\Genre;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua ID genre yang ada
        $genreIds = Genre::pluck('id');

        Film::create([
            'judul' => 'The Avengers',
            'sutradara' => 'Joss Whedon',
            'tahun' => 2012,
            'genre_id' => $genreIds->random()
        ]);

        Film::create([
            'judul' => 'Parasite',
            'sutradara' => 'Bong Joon Ho',
            'tahun' => 2019,
            'genre_id' => $genreIds->random()
        ]);

        Film::create([
            'judul' => 'Joker',
            'sutradara' => 'Todd Phillips',
            'tahun' => 2019,
            'genre_id' => $genreIds->random()
        ]);

        Film::create([
            'judul' => 'Pengabdi Setan 2: Communion',
            'sutradara' => 'Joko Anwar',
            'tahun' => 2022,
            'genre_id' => Genre::where('nama_genre', 'Horror')->first()->id
        ]);
    }
}
