<x-app-layout>
    @section('title', 'Tambah Kategori Surat')

    <div class="space-y-6">
        <!-- Header with Back Button -->
        <div class="flex items-center gap-4">
            <a href="{{ route('kategori.index') }}" class="inline-flex items-center gap-2 border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-semibold py-2 px-4 rounded-xl text-sm transition duration-150 shadow-sm bg-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Form Card Container -->
        <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm hover:shadow-md transition duration-200">
            <form action="{{ route('kategori.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Kategori -->
                    <div class="space-y-1.5">
                        <label for="nama" class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Nama Kategori</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required placeholder="Contoh: Nota Dinas" class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-3 px-4 text-sm text-gray-700 transition">
                        @error('nama')
                            <span class="text-xs text-red-500 font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Kode Kategori -->
                    <div class="space-y-1.5">
                        <label for="kode" class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Kode Kategori</label>
                        <input type="text" name="kode" id="kode" value="{{ old('kode') }}" required placeholder="Contoh: CAT-001" class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-3 px-4 text-sm text-gray-700 transition">
                        @error('kode')
                            <span class="text-xs text-red-500 font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Deskripsi (textarea, full width) -->
                <div class="space-y-1.5">
                    <label for="deskripsi" class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Tuliskan deskripsi lengkap mengenai pengarsipan kategori ini..." class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-3 px-4 text-sm text-gray-700 transition leading-relaxed">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <span class="text-xs text-red-500 font-semibold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Footer Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50">
                    <a href="{{ route('kategori.index') }}" class="border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-bold py-3 px-8 rounded-xl text-sm transition duration-150 shadow-sm text-center">
                        Batal
                    </a>
                    <button type="submit" class="bg-[#111827] hover:bg-black text-white font-bold py-3 px-8 rounded-xl text-sm transition duration-150 shadow-sm text-center">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <footer class="w-full text-center text-xs font-semibold text-gray-400 pt-6 border-t border-gray-100 block mx-auto">
            © 2026 SUBER - Sistem Informasi Surat
        </footer>
    </div>
</x-app-layout>
