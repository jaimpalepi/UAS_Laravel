<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full md:w-1/2 lg:w-1/3 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $film_id ? 'Edit Film' : 'Tambah Film Baru' }}</h3>
            <div class="mt-2 px-7 py-3">
                <form wire:submit.prevent="store">
                    <div class="mb-4 text-left">
                        <label for="judul" class="block text-gray-700 text-sm font-bold mb-2">Judul:</label>
                        <input type="text" wire:model="judul" id="judul" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('judul') <span class="text-red-500 text-xs italic">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4 text-left">
                        <label for="sutradara" class="block text-gray-700 text-sm font-bold mb-2">Sutradara:</label>
                        <input type="text" wire:model="sutradara" id="sutradara" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('sutradara') <span class="text-red-500 text-xs italic">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-4 text-left">
                        <label for="tahun" class="block text-gray-700 text-sm font-bold mb-2">Tahun:</label>
                        <input type="number" wire:model="tahun" id="tahun" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('tahun') <span class="text-red-500 text-xs italic">{{ $message }}</span>@enderror
                    </div>
                     <div class="mb-4 text-left">
                        <label for="genre_id" class="block text-gray-700 text-sm font-bold mb-2">Genre:</label>
                        <select wire:model="genre_id" id="genre_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Pilih Genre</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}">{{ $genre->nama_genre }}</option>
                            @endforeach
                        </select>
                        @error('genre_id') <span class="text-red-500 text-xs italic">{{ $message }}</span>@enderror
                    </div>
                    <div class="flex items-center justify-end px-4 py-3 gap-2">
                        <button wire:click="closeModal()" type="button" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Batal
                        </button>
                        <button type="submit" id="submit-btn" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
