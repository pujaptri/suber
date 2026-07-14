<x-app-layout>
    @section('title', 'Kategori Surat')

    <div class="space-y-6" x-data="{ deleteModalOpen: false, deleteActionUrl: '', deleteNamaKategori: '' }">
        <!-- Success Flash Toast Notification -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex items-center justify-between gap-3 max-w-md mx-auto relative z-50">
                <div class="flex items-center gap-2.5">
                    <div class="w-6 h-6 rounded-full bg-green-50 text-green-600 flex items-center justify-center font-bold text-xs shrink-0">
                        ✓
                    </div>
                    <span class="text-sm font-semibold text-gray-700">{{ session('success') }}</span>
                </div>
                <button type="button" @click="show = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Title and Quick Action Buttons -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1">
                <h3 class="text-2xl font-bold text-gray-800 tracking-tight">Daftar Kategori Surat</h3>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <!-- Search input -->
                <form method="GET" action="{{ route('kategori.index') }}" class="relative w-64 md:w-80">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..." class="w-full bg-slate-50 border border-gray-150 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-2.5 pl-11 pr-4 text-sm text-gray-700 transition">
                </form>

                <!-- Tambah Kategori Button -->
                <a href="{{ route('kategori.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-xl text-sm transition duration-150 shadow-md shadow-blue-100 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Kategori
                </a>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition duration-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-gray-50 text-gray-400 text-xs font-bold uppercase tracking-wider">
                            <th class="py-4.5 px-6 w-16 text-center">No</th>
                            <th class="py-4.5 px-6">Nama Kategori</th>
                            <th class="py-4.5 px-6">Kode Kategori</th>
                            <th class="py-4.5 px-6">Deskripsi</th>
                            <th class="py-4.5 px-6 text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @if($kategoriList->isNotEmpty())
                            @foreach($kategoriList as $index => $kategori)
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="py-4 px-6 text-center text-sm font-semibold text-gray-500">
                                        {{ ($kategoriList->currentPage() - 1) * $kategoriList->perPage() + $index + 1 }}
                                    </td>
                                    <td class="py-4 px-6 text-sm font-bold text-gray-900">
                                        {{ $kategori->nama }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="inline-block text-[11px] font-bold px-2.5 py-1 bg-gray-100 text-gray-700 rounded border border-gray-200 uppercase tracking-wide">
                                            {{ $kategori->kode }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-500 font-medium">
                                        {{ $kategori->deskripsi ?? '-' }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- View -->
                                            <a href="{{ route('kategori.show', $kategori->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-100 rounded-lg transition" title="Lihat">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <!-- Edit -->
                                            <a href="{{ route('kategori.edit', $kategori->id) }}" class="p-1.5 text-gray-500 hover:bg-gray-50 border border-gray-200 rounded-lg transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                </svg>
                                            </a>
                                            <!-- Delete -->
                                            <button type="button" @click.prevent="deleteModalOpen = true; deleteActionUrl = '{{ route('kategori.destroy', $kategori->id) }}'; deleteNamaKategori = '{{ $kategori->nama }}';" class="p-1.5 text-red-600 hover:bg-red-50 border border-red-100 rounded-lg transition" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="py-8 px-6 text-center text-sm font-semibold text-gray-400">
                                    Tidak ada data kategori ditemukan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Table Footer Pagination -->
            <div class="px-6 py-4 bg-slate-50/30 border-t border-gray-50 flex items-center justify-between flex-wrap gap-4">
                <span class="text-xs font-semibold text-gray-400">
                    Menampilkan {{ $kategoriList->firstItem() ?? 0 }} sampai {{ $kategoriList->lastItem() ?? 0 }} dari {{ $kategoriList->total() }} data
                </span>
                <div class="flex items-center gap-1.5">
                    {{ $kategoriList->links() }}
                </div>
            </div>
        </div>

        <!-- Custom Delete Confirmation Modal -->
        <div x-show="deleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-slate-900/30 backdrop-blur-sm transition-opacity" @click="deleteModalOpen = false"></div>
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div x-show="deleteModalOpen" x-transition class="relative transform overflow-hidden rounded-2xl bg-white p-8 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100 flex flex-col items-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-amber-50 text-amber-500 mb-6">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="text-center space-y-4 w-full">
                        <h3 class="text-2xl font-black text-gray-900 uppercase tracking-wide">Hapus Kategori?</h3>
                        <div class="h-0.5 bg-gray-100 w-full my-4"></div>
                        <p class="text-sm text-gray-500 leading-relaxed font-medium">
                            Apakah Anda yakin ingin menghapus kategori <span class="font-bold text-gray-900" x-text="deleteNamaKategori"></span>? Tindakan ini akan menghapus data kategori klasifikasi secara permanen dari sistem.
                        </p>
                    </div>
                    <div class="flex items-center justify-center gap-4 mt-8 w-full">
                        <button type="button" @click="deleteModalOpen = false" class="flex-1 border border-gray-200 text-gray-650 hover:text-gray-900 hover:bg-gray-50 font-bold py-3.5 px-6 rounded-xl text-sm transition duration-150 shadow-sm text-center">
                            BATAL
                        </button>
                        <form :action="deleteActionUrl" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-[#111827] hover:bg-black text-white font-bold py-3.5 px-6 rounded-xl text-sm transition duration-150 shadow-sm text-center uppercase">
                                YA, HAPUS
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w-full text-center text-xs font-semibold text-gray-400 pt-6 border-t border-gray-100 block mx-auto">
        © 2026 SUBER - Sistem Informasi Surat
    </footer>
</x-app-layout>
