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

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testLogin(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('email', 'admin@cinema.app')->first();

            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'admin1234')
                ->click('#login-button')
                ->assertPathIs('/dashboard');
        });
    }

    public function testFilmCreate(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('email', 'admin@cinema.app')->first();
            $browser->loginAs($user)
                    ->visit('/manage-films');

            $browser->press('Tambah Film Baru')
                    ->whenAvailable('form[wire\:submit\.prevent="store"]', function ($modal) {
                        $modal->type('#judul', 'Film Test Dusk')
                              ->type('#sutradara', 'Sutradara Test')
                              ->type('#tahun', '2024')
                              ->select('#genre_id', '1')
                              ->click('#submit-btn');
                    })
                    ->waitForText('Film Berhasil Ditambahkan.')
                    ->assertSee('Film Berhasil Ditambahkan.');
        });
    }

    public function testFilmRead(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('email', 'admin@cinema.app')->first();

            $browser->loginAs($user)
                    ->visit('/manage-films');

            $browser->press('Tambah Film Baru')
                    ->whenAvailable('form[wire\:submit\.prevent="store"]', function ($modal) {
                        $modal->type('#judul', 'Film Test Dusk')
                              ->type('#sutradara', 'Sutradara Test')
                              ->type('#tahun', '2024')
                              ->select('#genre_id', '1')
                              ->click('#submit-btn');
                    })
                    ->waitForText('Film Berhasil Ditambahkan.')
                    ->assertSee('Film Berhasil Ditambahkan.')
                    ->assertSee('Film Test Dusk');
        });
    }

    public function testFilmUpdate(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('email', 'admin@cinema.app')->first();

            $browser->loginAs($user)
                    ->visit('/manage-films');

            $film = Film::first();
            if ($film) {
                $browser->press('@edit-film-' . $film->id)
                        ->whenAvailable('form[wire\:submit\.prevent="store"]', function ($modal) {
                            $modal->type('#judul', 'Film Test Dusk Updated')
                                  ->type('#sutradara', 'Sutradara Test Updated')
                                  ->type('#tahun', '2025')
                                  ->select('#genre_id', '2')
                                  ->click('#submit-btn');
                        })
                        ->waitForText('Film Berhasil Diperbarui.')
                        ->assertSee('Film Berhasil Diperbarui.');

                $browser->visit('/manage-films')
                        ->assertSee('Film Test Dusk Updated')
                        ->assertSee('Sutradara Test Updated')
                        ->assertSee('2025');
            }
        });
    }

    public function testFilmDelete(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('email', 'admin@cinema.app')->first();

            $browser->loginAs($user)
                    ->visit('/manage-films');

            $film = Film::first();
            if ($film) {
                $browser->press('Hapus')
                        ->acceptDialog()
                        ->waitForText('Film Berhasil Dihapus.')
                        ->assertSee('Film Berhasil Dihapus.');
            }
        });
    }
}

