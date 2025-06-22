<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Studio;

class StudioSeeder extends Seeder
{
    public function run(): void
    {
        Studio::create(['nama_studio' => 'Studio 1', 'kapasitas' => 100]);
        Studio::create(['nama_studio' => 'Studio 2', 'kapasitas' => 80]);
        Studio::create(['nama_studio' => 'IMAX 3', 'kapasitas' => 150]);
    }
}