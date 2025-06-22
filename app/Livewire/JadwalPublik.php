<?php

namespace App\Livewire;

use App\Models\Genre;
use App\Models\JadwalTayang;
use App\Models\Tiket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class JadwalPublik extends Component
{
    public $selectedDate;
    public $selectedGenre;

    public function mount()
    {
        $this->selectedDate = date('Y-m-d');
    }

    public function render()
    {
        $genres = Genre::all();

        // Menghitung tiket yang terjual ATAU pending untuk menentukan ketersediaan
        $query = JadwalTayang::with(['film.genre', 'studio'])
            ->withCount(['tiket' => function ($query) {
                $query->whereIn('status', ['terjual', 'pending']);
            }])
            ->where('tanggal', $this->selectedDate);

        if ($this->selectedGenre) {
            $query->whereHas('film', function ($q) {
                $q->where('genre_id', $this->selectedGenre);
            });
        }

        $jadwals = $query->get();

        return view('livewire.jadwal-publik', compact('jadwals', 'genres'));
    }

    public function beliTiket($jadwalId)
    {
        // Cek apakah user sudah login, jika belum, arahkan ke halaman login
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }

        $jadwal = JadwalTayang::withCount(['tiket' => function ($query) {
                $query->whereIn('status', ['terjual', 'pending']);
        }])->find($jadwalId);

        // Cek ketersediaan tiket
        if ($jadwal && $jadwal->tiket_count < $jadwal->jumlah_tiket) {
            
            // Buat tiket baru dengan status PENDING
            $tiket = Tiket::create([
                'jadwal_tayang_id' => $jadwalId,
                'harga' => 50000,
                'status' => 'pending'
            ]);

            // [PERBAIKAN] Hapus 'navigate: true' untuk menggunakan redirect standar
            return $this->redirect(route('payment.page', ['tiket' => $tiket->id]));

        } else {
            session()->flash('error', 'Maaf, tiket untuk jadwal ini sudah habis.');
        }
    }
}
