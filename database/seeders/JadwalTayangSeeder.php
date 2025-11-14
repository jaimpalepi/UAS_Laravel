<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalTayang;
use App\Models\Film;
use App\Models\Studio;
use App\Models\Tiket; // 1. TAMBAHKAN BARIS INI untuk mengimpor model Tiket

class JadwalTayangSeeder extends Seeder
{
    public function run(): void
    {
        $filmIds = Film::pluck('id');
        $studioIds = Studio::pluck('id');
        $jamTayang = ['13:00', '15:30', '18:00', '20:30'];



        // Hapus jadwal lama agar tidak ada duplikat
        JadwalTayang::query()->delete();

        // Buat jadwal untuk hari ini
        foreach ($studioIds as $studioId) {
            JadwalTayang::create([
                'film_id' => $filmIds->random(),
                'studio_id' => $studioId,
                'tanggal' => now()->toDateString(),
                'jam' => $jamTayang[array_rand($jamTayang)],
                'jumlah_tiket' => 100,
            ]);
        }
        
        // Buat jadwal untuk besok
         foreach ($studioIds as $studioId) {
            JadwalTayang::create([
                'film_id' => $filmIds->random(),
                'studio_id' => $studioId,
                'tanggal' => now()->addDay()->toDateString(),
                'jam' => $jamTayang[array_rand($jamTayang)],
                'jumlah_tiket' => 100,
            ]);
        }
    }
}
