<?php

namespace App\Livewire;

use App\Models\Tiket;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PaymentPage extends Component
{
    public Tiket $tiket;

    public function mount(Tiket $tiket)
    {
        // Pastikan tiket yang diakses masih dalam status pending
        if ($this->tiket->status !== 'pending') {
            session()->flash('error', 'Tiket ini sudah tidak valid atau sudah dibayar.');
            return $this->redirect(route('home'));
        }
        // Muat relasi yang dibutuhkan untuk menampilkan detail
        $this->tiket->load('jadwalTayang.film', 'jadwalTayang.studio');
    }

    public function render()
    {
        return view('livewire.payment-page');
    }

    // Method untuk mengkonfirmasi pembayaran
    public function confirmPayment()
    {
        // Ubah status tiket menjadi 'terjual'
        $this->tiket->update(['status' => 'terjual']);

        session()->flash('success', 'Pembayaran berhasil! Tiket Anda sudah dikonfirmasi.');

        // [PERBAIKAN] Gunakan redirect standar dengan menghapus 'navigate: true'
        return $this->redirect(route('home'));
    }
}
