<x-app-layout>
    @section('title', 'Detail Kategori Surat')

    <div class="space-y-6">
        <!-- Header with Back Button -->
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('kategori.index') }}" class="inline-flex items-center gap-2 border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-semibold py-2 px-4 rounded-xl text-sm transition duration-150 shadow-sm bg-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
            <a href="{{ route('kategori.edit', $kategori->id) }}" class="inline-flex items-center gap-2 bg-[#111827] hover:bg-black text-white font-bold py-2 px-4 rounded-xl text-sm transition duration-150 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
                Edit Kategori
            </a>
        </div>

        <!-- Detail Card -->
        <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm hover:shadow-md transition duration-200 relative">
            <!-- Header Grid info -->
            <div class="flex justify-between items-start mb-6">
                <div class="space-y-1">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Kategori Surat</span>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-1 leading-tight">{{ $kategori->nama }}</h3>
                </div>
                <div>
                    <span class="inline-block text-xs font-bold px-3 py-1.5 bg-gray-100 text-gray-700 rounded border border-gray-200 uppercase tracking-wide">
                        {{ $kategori->kode }}
                    </span>
                </div>
            </div>

            <div class="h-px bg-gray-150 my-6"></div>

            <!-- Details Block -->
            <div class="space-y-4">
                <div class="space-y-1.5">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Deskripsi Lengkap</span>
                    <div class="bg-slate-50/60 p-5 rounded-xl border border-gray-100 text-gray-750 text-sm leading-relaxed whitespace-pre-line font-medium">
                        {{ $kategori->deskripsi ?? 'Tidak ada deskripsi untuk kategori ini.' }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-50 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                    <div>
                        <span>Dibuat Pada:</span>
                        <span class="text-gray-700 font-bold block mt-1">{{ $kategori->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</span>
                    </div>
                    <div>
                        <span>Terakhir Diperbarui:</span>
                        <span class="text-gray-700 font-bold block mt-1">{{ $kategori->updated_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="w-full text-center text-xs font-semibold text-gray-400 pt-6 border-t border-gray-100 block mx-auto">
            © 2026 SUBER - Sistem Informasi Surat
        </footer>
    </div>
</x-app-layout>
