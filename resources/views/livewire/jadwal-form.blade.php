<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full md:w-1/2 lg:w-1/3 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $jadwal_id ? 'Edit Jadwal' : 'Tambah Jadwal Baru' }}</h3>
            <div class="mt-2 px-7 py-3">
                <form wire:submit="store">
                    <div class="mb-4 text-left">
                        <label for="film_id" class="block text-gray-700 text-sm font-bold mb-2">Film:</label>
                        <select wire:model.live="film_id" id="film_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Pilih Film</option>
                            @foreach($films as $film)
                                <option value="{{ $film->id }}">{{ $film->judul }}</option>
                            @endforeach
                        </select>
                        @error('film_id') <span class="text-red-500 text-xs italic">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4 text-left">
                        <label for="studio_id" class="block text-gray-700 text-sm font-bold mb-2">Studio:</label>
                        <select wire:model.live="studio_id" id="studio_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Pilih Studio</option>
                            @foreach($studios as $studio)
                                <option value="{{ $studio->id }}">{{ $studio->nama_studio }}</option>
                            @endforeach
                        </select>
                        @error('studio_id') <span class="text-red-500 text-xs italic">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4 text-left">
                        <label for="tanggal" class="block text-gray-700 text-sm font-bold mb-2">Tanggal:</label>
                        <input type="date" wire:model.live="tanggal" id="tanggal" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('tanggal') <span class="text-red-500 text-xs italic">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4 text-left">
                        <label for="jam" class="block text-gray-700 text-sm font-bold mb-2">Jam:</label>
                        <input type="time" wire:model.live="jam" id="jam" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('jam') <span class="text-red-500 text-xs italic">{{ $message }}</span>@enderror
                    </div>
                    
                    <div class="mb-4 text-left">
                        <label for="jumlah_tiket" class="block text-gray-700 text-sm font-bold mb-2">Jumlah Tiket Dijual:</label>
                        <input type="number" wire:model.live="jumlah_tiket" id="jumlah_tiket" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="e.g. 100">
                        @error('jumlah_tiket') <span class="text-red-500 text-xs italic">{{ $message }}</span>@enderror
                    </div>

                    <div class="flex items-center justify-end px-4 py-3 gap-2">
                        <button wire:click="closeModal()" type="button" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
