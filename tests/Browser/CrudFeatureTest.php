<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Film;
use App\Models\Studio;
use App\Models\JadwalTayang;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class CrudFeatureTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Seed the database before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        // Jalankan seeder untuk menyiapkan data awal, termasuk user admin
        $this->artisan('db:seed');
    }

    /**
     * @group login
     * Test user dapat login dengan kredensial yang benar.
     *
     * @return void
     * @throws Throwable
     */
    public function testLogin(): void
    {
        $this->browse(function (Browser $browser) {
            // Ambil user admin yang sudah ada dari database
            $user = User::where('email', 'admin@cinema.app')->first();

            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'password') // Asumsi password default adalah 'password'
                    ->press('Login')
                    ->assertPathIs('/dashboard')
                    ->assertSee('Dashboard');
        });
    }

    /**
     * @group crud
     * Test fungsionalitas CRUD (Create, Read, Update, Delete) untuk Jadwal Tayang.
     *
     * @return void
     * @throws Throwable
     */
    public function testJadwalTayangCrud(): void
    {
        $this->browse(function (Browser $browser) {
            // Ambil data yang diperlukan dari database
            $user = User::where('email', 'admin@cinema.app')->first();
            $film = Film::first();
            $studio = Studio::first();

            // Login sebagai admin sebelum memulai tes CRUD
            $browser->loginAs($user)
                    ->visit('/jadwal-manager');

            // --- 1. Test Create Data ---
            $browser->press('Tambah Jadwal Baru')
                    ->whenAvailable('.modal', function ($modal) use ($film, $studio) {
                        $modal->select('film_id', $film->id)
                              ->select('studio_id', $studio->id)
                              ->type('tanggal', '20-11-2025') // Gunakan format YYYY-MM-DD
                              ->type('jam', '19:00')
                              ->type('jumlah_tiket', '150')
                              ->press('Simpan');
                    })
                    ->assertSee('Jadwal Berhasil Dibuat.');

            // --- 2. Test Read Data ---
            // Verifikasi data yang baru dibuat muncul di halaman
            $browser->assertSee($film->judul)
                    ->assertSee($studio->nama_studio)
                    ->assertSee('20-11-2025') // Sesuaikan format tanggal yang ditampilkan di view
                    ->assertSee('19:00')
                    ->assertSee('150');

            // --- 3. Test Update Data ---
            // Cari baris data yang baru dibuat dan klik tombol edit
            $browser->with("tr:contains('{$film->judul}')", function ($row) {
                        $row->press('Edit');
                    })
                    ->whenAvailable('.modal', function ($modal) {
                        // Ubah jumlah tiket
                        $modal->clear('jumlah_tiket')->type('jumlah_tiket', '175');
                        $modal->press('Simpan');
                    })
                    ->assertSee('Jadwal Berhasil Diperbarui.');

            // Verifikasi bahwa data telah diperbarui
            $browser->assertSee('175');

            // --- 4. Test Delete Data ---
            // Cari baris data yang sudah diupdate dan klik tombol hapus
            $browser->with("tr:contains('{$film->judul}')", function ($row) {
                        $row->press('Hapus');
                    });

            // Dusk akan otomatis menangani konfirmasi browser (wire:confirm)
            // Verifikasi pesan sukses penghapusan
            $browser->assertSee('Jadwal Berhasil Dihapus.');

            // Verifikasi bahwa data sudah tidak ada lagi di tabel
            $browser->assertDontSee($film->judul);
        });
    }
}