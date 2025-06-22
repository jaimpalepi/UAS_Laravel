    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Konfirmasi Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold mb-6 text-center text-gray-800">Detail Pembelian Tiket</h3>
                    
                    <div class="border-t border-b border-gray-200 py-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Film</dt>
                                <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $tiket->jadwalTayang->film->judul }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Jadwal</dt>
                                <dd class="mt-1 text-lg text-gray-900">{{ \Carbon\Carbon::parse($tiket->jadwalTayang->tanggal)->format('d F Y') }} - {{ \Carbon\Carbon::parse($tiket->jadwalTayang->jam)->format('H:i') }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Studio</dt>
                                <dd class="mt-1 text-lg text-gray-900">{{ $tiket->jadwalTayang->studio->nama_studio }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Total Harga</dt>
                                <dd class="mt-1 text-3xl font-bold text-indigo-600">Rp {{ number_format($tiket->harga, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    <div class="mt-8">
                        <button wire:click="confirmPayment" wire:loading.attr="disabled" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-lg text-lg transition duration-300 ease-in-out">
                            Konfirmasi Pembayaran
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    