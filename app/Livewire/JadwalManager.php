<?php

namespace App\Livewire;

use App\Models\JadwalTayang;
use App\Models\Film;
use App\Models\Studio;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class JadwalManager extends Component
{
    use WithPagination;

    // Properti untuk data form
    public $jadwal_id, $film_id, $studio_id, $tanggal, $jam, $jumlah_tiket;

    public $isModalOpen = false;

    // Aturan validasi
    protected function rules()
    {
        return [
            'film_id' => 'required|exists:films,id',
            'studio_id' => 'required|exists:studios,id',
            'tanggal' => 'required|date',
            'jumlah_tiket' => 'required|integer|min:1',
            'jam' => [
                'required',
                Rule::unique('jadwal_tayangs')->where(function ($query) {
                    return $query->where('studio_id', $this->studio_id)
                                 ->where('tanggal', $this->tanggal);
                })->ignore($this->jadwal_id),
            ],
        ];
    }
    
    // Pesan validasi kustom
    protected $messages = [
        'jam.unique' => 'Jadwal untuk studio, tanggal, dan jam yang sama sudah ada.',
        'film_id.required' => 'Silakan pilih film.',
        'studio_id.required' => 'Silakan pilih studio.',
        'jumlah_tiket.required' => 'Jumlah tiket harus diisi.',
        'jumlah_tiket.min' => 'Jumlah tiket minimal 1.',
    ];

    public function render()
    {
        $jadwals = JadwalTayang::with(['film', 'studio'])->withCount('tiket')->latest()->paginate(5);
        $films = Film::orderBy('judul')->get();
        $studios = Studio::orderBy('nama_studio')->get();

        return view('livewire.jadwal-manager', [
            'jadwals' => $jadwals,
            'films' => $films,
            'studios' => $studios,
        ]);
    }

    public function create()
    {
        $this->reset();
        $this->openModal();
    }

    public function openModal() { $this->isModalOpen = true; }
    public function closeModal() { $this->isModalOpen = false; }

    // Method store() dengan logika yang diperbarui
    public function store()
    {
        $validatedData = $this->validate();

        // Jika sedang mengedit, lakukan pengecekan tiket terjual
        if ($this->jadwal_id) {
            $jadwal = JadwalTayang::withCount('tiket')->find($this->jadwal_id);
            if ($validatedData['jumlah_tiket'] < $jadwal->tiket_count) {
                 // Tambahkan error dan hentikan proses jika tiket dijual lebih sedikit dari yang sudah laku
                 $this->addError('jumlah_tiket', 'Tidak boleh kurang dari tiket yang sudah terjual (' . $jadwal->tiket_count . ').');
                 return;
            }
        }

        // Simpan atau perbarui data jadwal tayang
        JadwalTayang::updateOrCreate(['id' => $this->jadwal_id], $validatedData);

        session()->flash('message', $this->jadwal_id ? 'Jadwal Berhasil Diperbarui.' : 'Jadwal Berhasil Dibuat.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $jadwal = JadwalTayang::findOrFail($id);
        $this->jadwal_id = $id;
        $this->film_id = $jadwal->film_id;
        $this->studio_id = $jadwal->studio_id;
        $this->tanggal = $jadwal->tanggal;
        $this->jam = $jadwal->jam;
        $this->jumlah_tiket = $jadwal->jumlah_tiket;
        
        $this->openModal();
    }

    public function delete($id)
    {
        JadwalTayang::find($id)->delete();
        session()->flash('message', 'Jadwal Berhasil Dihapus.');
    }
}
