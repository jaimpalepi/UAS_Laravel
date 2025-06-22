<?php

namespace App\Livewire;

use App\Models\Film;
use App\Models\Genre;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class FilmManager extends Component
{
    use WithPagination;

    // Properti untuk data form
    public $film_id, $judul, $sutradara, $tahun, $genre_id;

    // Properti untuk UI
    public $isModalOpen = false;
    public $search = '';

    // Method render untuk menampilkan view
    public function render()
    {
        // Ambil data film dengan paginasi dan pencarian
        $films = Film::with('genre')
            ->where('judul', 'like', '%'.$this->search.'%')
            ->latest()
            ->paginate(5);
            
        // Ambil semua data genre untuk dropdown
        $genres = Genre::orderBy('nama_genre')->get();
        
        return view('livewire.film-manager', [
            'films' => $films,
            'genres' => $genres
        ]);
    }

    // Membuka modal untuk menambah film baru
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    // Membuka modal
    public function openModal()
    {
        $this->isModalOpen = true;
    }

    // Menutup modal
    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    // Mereset semua field form
    private function resetInputFields()
    {
        $this->film_id = null;
        $this->judul = '';
        $this->sutradara = '';
        $this->tahun = '';
        $this->genre_id = '';
    }

    // Method untuk menyimpan data (baik baru maupun update)
    public function store()
    {
        $this->validate([
            'judul' => 'required|string|max:255',
            'sutradara' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'genre_id' => 'required|exists:genres,id',
        ]);

        Film::updateOrCreate(['id' => $this->film_id], [
            'judul' => $this->judul,
            'sutradara' => $this->sutradara,
            'tahun' => $this->tahun,
            'genre_id' => $this->genre_id,
        ]);

        session()->flash('message', $this->film_id ? 'Film Berhasil Diperbarui.' : 'Film Berhasil Ditambahkan.');

        $this->closeModal();
        $this->resetInputFields();
    }

    // Mengisi form dengan data untuk diedit
    public function edit($id)
    {
        $film = Film::findOrFail($id);
        $this->film_id = $id;
        $this->judul = $film->judul;
        $this->sutradara = $film->sutradara;
        $this->tahun = $film->tahun;
        $this->genre_id = $film->genre_id;
        
        $this->openModal();
    }

    // Menghapus data film
    public function delete($id)
    {
        Film::find($id)->delete();
        session()->flash('message', 'Film Berhasil Dihapus.');
    }
}
