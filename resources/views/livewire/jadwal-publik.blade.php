<div class="p-6">
    <h2 class="text-3xl font-bold text-center mb-6">Jadwal Tayang Film</h2>

    {{-- Notifikasi --}}
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    {{-- Filter --}}
    <div class="flex flex-wrap gap-4 justify-center mb-8 p-4 bg-white rounded-lg shadow">
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date" wire:model.live="selectedDate" id="date" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
        </div>
        <div>
            <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
            <select wire:model.live="selectedGenre" id="genre" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">Semua Genre</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->nama_genre }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Daftar Jadwal --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($jadwals as $jadwal)
            @php
                // Logika penghitungan baru
                $totalDijual = $jadwal->jumlah_tiket;
                $tiketTerjual = $jadwal->tiket_count; // Menggunakan properti dari withCount()
                $tiketTersedia = $totalDijual - $tiketTerjual;
            @endphp

            <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300">
                <div class="p-6">
                    <span class="text-sm text-gray-500">{{ $jadwal->studio->nama_studio }}</span>
                    <h3 class="text-xl font-bold mb-2">{{ $jadwal->film->judul }} ({{ $jadwal->film->tahun }})</h3>
                    <p class="text-gray-600 mb-1">Sutradara: {{ $jadwal->film->sutradara }}</p>
                    <p class="text-gray-600 mb-4">Genre: <span class="bg-gray-200 text-gray-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">{{ $jadwal->film->genre->nama_genre }}</span></p>

                    <div class="flex justify-between items-center mb-4">
                        <p class="text-lg font-bold text-indigo-600">{{ \Carbon\Carbon::parse($jadwal->jam)->format('H:i') }}</p>
                        <p class="text-md font-semibold">
                            Tiket Tersedia: 
                            <span class="text-green-600">{{ $tiketTersedia }}</span> / {{ $totalDijual }}
                        </p>
                    </div>

                    @if ($tiketTersedia > 0)
                        <button wire:click="beliTiket({{ $jadwal->id }})" wire:loading.attr="disabled" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition-colors duration-300">
                            Beli Tiket (Rp 50.000)
                        </button>
                    @else
                        <button class="w-full bg-red-500 text-white font-bold py-2 px-4 rounded cursor-not-allowed" disabled>
                            Tiket Habis
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="md:col-span-2 lg:col-span-3 text-center py-12">
                <p class="text-gray-500 text-lg">Tidak ada jadwal tayang untuk filter yang dipilih.</p>
            </div>
        @endforelse
    </div>
</div>
