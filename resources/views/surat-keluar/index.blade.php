<x-app-layout>
    @section('title', 'Surat Keluar')

    <div class="space-y-6" x-data="{ deleteModalOpen: false, deleteActionUrl: '', deleteNomorSurat: '' }">
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
        @endif        <!-- Title and Quick Action Buttons -->
        <div class="flex items-center justify-between">
            <h3 class="text-2xl font-bold text-gray-800 tracking-tight">Daftar Surat Keluar</h3>
            <div class="flex items-center gap-3">
                <!-- Tambah Surat -->
                <a href="{{ route('surat-keluar.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-xl text-sm transition duration-150 shadow-md shadow-blue-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Surat
                </a>
            </div>
        </div>

        <!-- Filter Card -->
        <form method="GET" action="{{ route('surat-keluar.index') }}" class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-200">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 block">Filter Data</span>
            
            <div class="space-y-4">
                <!-- Search input -->
                <div>
                    <label for="search" class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5 block">Cari Surat</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari surat atau nomor agenda..." class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-3 pl-11 pr-4 text-sm text-gray-700 transition">
                    </div>
                </div>

                <!-- Inputs Grid -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                    <!-- Tanggal Dari -->
                    <div class="md:col-span-1">
                        <label for="tanggal_dari" class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5 block">Tanggal Dari</label>
                        <input type="date" name="tanggal_dari" id="tanggal_dari" value="{{ request('tanggal_dari') }}" class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-2.5 px-4 text-sm text-gray-700 transition">
                    </div>

                    <!-- Tanggal Sampai -->
                    <div class="md:col-span-1">
                        <label for="tanggal_sampai" class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5 block">Tanggal Sampai</label>
                        <input type="date" name="tanggal_sampai" id="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-2.5 px-4 text-sm text-gray-700 transition">
                    </div>

                    <!-- Kategori -->
                    <div class="md:col-span-1">
                        <label for="kategori" class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5 block">Kategori</label>
                        <select name="kategori" id="kategori" class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-2.5 px-4 text-sm text-gray-700 transition cursor-pointer">
                            <option value="">Semua Kategori</option>
                            <option value="internal" {{ request('kategori') == 'internal' ? 'selected' : '' }}>Internal</option>
                            <option value="eksternal" {{ request('kategori') == 'eksternal' ? 'selected' : '' }}>Eksternal</option>
                            <option value="undangan" {{ request('kategori') == 'undangan' ? 'selected' : '' }}>Undangan</option>
                            <option value="pemberitahuan" {{ request('kategori') == 'pemberitahuan' ? 'selected' : '' }}>Pemberitahuan</option>
                            <option value="lainnya" {{ request('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <!-- Bagian -->
                    <div class="md:col-span-1">
                        <label for="bagian" class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5 block">Bagian</label>
                        <select name="bagian" id="bagian" class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-2.5 px-4 text-sm text-gray-700 transition cursor-pointer">
                            <option value="">Semua Bagian</option>
                        </select>
                    </div>

                    <!-- Action buttons -->
                    <div class="md:col-span-1 flex gap-3">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-xl text-sm transition duration-150 shadow-sm text-center">
                            Terapkan
                        </button>
                        <a href="{{ route('surat-keluar.index') }}" class="flex-1 border border-blue-600 text-blue-600 hover:bg-blue-50 font-semibold py-2.5 px-4 rounded-xl text-sm transition duration-150 shadow-sm text-center">
                            Reset
                        </a>
                    </div>
                </div>
        </form>

        <!-- Table Card -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition duration-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-gray-50 text-gray-400 text-xs font-bold uppercase tracking-wider">
                            <th class="py-4.5 px-4 w-16 text-center">No</th>
                            <th class="py-4.5 px-4">Nomor Surat</th>
                            <th class="py-4.5 px-4">Tanggal</th>
                            <th class="py-4.5 px-4">Penerima</th>
                            <th class="py-4.5 px-4">Perihal</th>
                            <th class="py-4.5 px-4 text-center w-44">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @if($suratKeluar->isNotEmpty())
                            @foreach($suratKeluar as $index => $surat)
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="py-4 px-4 text-center text-sm font-semibold text-gray-500">
                                        {{ ($suratKeluar->currentPage() - 1) * $suratKeluar->perPage() + $index + 1 }}
                                    </td>
                                    <td class="py-4 px-4 text-sm font-bold text-gray-900">
                                        {{ $surat->nomor_surat }}
                                    </td>
                                    <td class="py-4 px-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $surat->tanggal_surat->locale('id')->isoFormat('DD MMM Y') }}
                                    </td>
                                    <td class="py-4 px-4 text-sm text-gray-650 font-medium">
                                        {{ $surat->penerima }}
                                    </td>
                                    <td class="py-4 px-4 text-sm text-gray-500 leading-relaxed max-w-[180px] truncate">
                                        {{ $surat->perihal }}
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Tinjau (SuperAdmin Only and Status is Menunggu TTD) -->
                                            @if(Auth::user()->isSuperAdmin() && $surat->status === 'menunggu_ttd')
                                                <a href="{{ route('surat-keluar.tinjau', $surat->id) }}" class="p-1.5 text-indigo-650 hover:bg-indigo-50 border border-indigo-100 rounded-lg transition" title="Tinjau & Setujui">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path>
                                                    </svg>
                                                </a>
                                            @endif
                                            <!-- View -->
                                            <a href="{{ route('surat-keluar.show', $surat->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-100 rounded-lg transition" title="Lihat">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <!-- Edit -->
                                            @if(Auth::user()->isSuperAdmin() || in_array($surat->status, ['menunggu_ttd', 'revisi']))
                                                <a href="{{ route('surat-keluar.edit', $surat->id) }}" class="p-1.5 text-gray-500 hover:bg-gray-50 border border-gray-200 rounded-lg transition" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                    </svg>
                                                </a>
                                            @else
                                                <button type="button" disabled class="p-1.5 text-gray-300 border border-gray-100 rounded-lg cursor-not-allowed opacity-60" title="Sudah di-approve / ditolak">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                    </svg>
                                                </button>
                                            @endif
                                            <!-- Delete -->
                                            @if(Auth::user()->isSuperAdmin() || $surat->status !== 'disetujui')
                                                <button type="button" @click.prevent="deleteModalOpen = true; deleteActionUrl = '{{ route('surat-keluar.destroy', $surat->id) }}'; deleteNomorSurat = '{{ $surat->nomor_surat }}';" class="p-1.5 text-red-600 hover:bg-red-50 border border-red-100 rounded-lg transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            @else
                                                <button type="button" disabled class="p-1.5 text-gray-300 border border-gray-100 rounded-lg cursor-not-allowed opacity-60" title="Surat disetujui tidak dapat dihapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <!-- High Fidelity fallback rows from the mockup when DB is empty -->
                            <!-- Row 1 -->
                            <tr class="hover:bg-slate-50/30 transition">
                                <td class="py-4 px-4 text-center text-sm font-semibold text-gray-500">1</td>
                                <td class="py-4 px-4 text-sm font-bold text-gray-900">045/SK/XII/2024</td>
                                <td class="py-4 px-4 text-sm text-gray-500 whitespace-nowrap">12 Des 2024</td>
                                <td class="py-4 px-4 text-sm text-gray-600 font-medium">Kementerian Dalam Negeri</td>
                                <td class="py-4 px-4 text-sm text-gray-500 leading-relaxed max-w-[180px] truncate">Undangan Rapat Koordinasi Teknis</td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="#" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-100 rounded-lg transition" title="Lihat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="#" class="p-1.5 text-gray-500 hover:bg-gray-50 border border-gray-200 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>
                                        <button type="button" @click.prevent="deleteModalOpen = true; deleteActionUrl = '#'; deleteNomorSurat = '045/SK/XII/2024';" class="p-1.5 text-red-600 hover:bg-red-50 border border-red-100 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Row 2 -->
                            <tr class="hover:bg-slate-50/30 transition">
                                <td class="py-4 px-4 text-center text-sm font-semibold text-gray-500">2</td>
                                <td class="py-4 px-4 text-sm font-bold text-gray-900">120.2/X/2024/SETDA</td>
                                <td class="py-4 px-4 text-sm text-gray-500 whitespace-nowrap">11 Des 2024</td>
                                <td class="py-4 px-4 text-sm text-gray-600 font-medium">Pemerintah Provinsi Jatim</td>
                                <td class="py-4 px-4 text-sm text-gray-500 leading-relaxed max-w-[180px] truncate">Penyampaian Laporan Tahunan TA 2023</td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="#" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-100 rounded-lg transition" title="Lihat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="#" class="p-1.5 text-gray-500 hover:bg-gray-50 border border-gray-200 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>
                                        <button type="button" @click.prevent="deleteModalOpen = true; deleteActionUrl = '#'; deleteNomorSurat = '120.2/X/2024/SETDA';" class="p-1.5 text-red-600 hover:bg-red-50 border border-red-100 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Row 3 -->
                            <tr class="hover:bg-slate-50/30 transition">
                                <td class="py-4 px-4 text-center text-sm font-semibold text-gray-500">3</td>
                                <td class="py-4 px-4 text-sm font-bold text-gray-900">B/1402/XI/2024/Polres</td>
                                <td class="py-4 px-4 text-sm text-gray-500 whitespace-nowrap">10 Des 2024</td>
                                <td class="py-4 px-4 text-sm text-gray-650 font-medium">Kepolisian Resor Kota</td>
                                <td class="py-4 px-4 text-sm text-gray-500 leading-relaxed max-w-[180px] truncate">Permohonan Izin Keramaian HUT RI</td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="#" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-100 rounded-lg transition" title="Lihat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="#" class="p-1.5 text-gray-500 hover:bg-gray-50 border border-gray-200 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>
                                        <button type="button" @click.prevent="deleteModalOpen = true; deleteActionUrl = '#'; deleteNomorSurat = 'B/1402/XI/2024/Polres';" class="p-1.5 text-red-600 hover:bg-red-50 border border-red-100 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Row 4 -->
                            <tr class="hover:bg-slate-50/30 transition">
                                <td class="py-4 px-4 text-center text-sm font-semibold text-gray-500">4</td>
                                <td class="py-4 px-4 text-sm font-bold text-gray-900">ST-99/DISHUB/X/24</td>
                                <td class="py-4 px-4 text-sm text-gray-500 whitespace-nowrap">09 Des 2024</td>
                                <td class="py-4 px-4 text-sm text-gray-600 font-medium">Dinas Perhubungan</td>
                                <td class="py-4 px-4 text-sm text-gray-500 leading-relaxed max-w-[180px] truncate">Surat Tugas Pengamanan Jalan</td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="#" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-100 rounded-lg transition" title="Lihat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="#" class="p-1.5 text-gray-500 hover:bg-gray-50 border border-gray-200 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>
                                        <button type="button" @click.prevent="deleteModalOpen = true; deleteActionUrl = '#'; deleteNomorSurat = 'ST-99/DISHUB/X/24';" class="p-1.5 text-red-600 hover:bg-red-50 border border-red-100 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Row 5 -->
                            <tr class="hover:bg-slate-50/30 transition">
                                <td class="py-4 px-4 text-center text-sm font-semibold text-gray-500">5</td>
                                <td class="py-4 px-4 text-sm font-bold text-gray-900">PR-201/KOMINFO/2024</td>
                                <td class="py-4 px-4 text-sm text-gray-500 whitespace-nowrap">08 Des 2024</td>
                                <td class="py-4 px-4 text-sm text-gray-650 font-medium">Diskominfo</td>
                                <td class="py-4 px-4 text-sm text-gray-500 leading-relaxed max-w-[180px] truncate">Publikasi Iklan Layanan Masyarakat</td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="#" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-100 rounded-lg transition" title="Lihat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="#" class="p-1.5 text-gray-500 hover:bg-gray-50 border border-gray-200 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>
                                        <button type="button" @click.prevent="deleteModalOpen = true; deleteActionUrl = '#'; deleteNomorSurat = 'PR-201/KOMINFO/2024';" class="p-1.5 text-red-600 hover:bg-red-50 border border-red-100 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Table Footer Pagination -->
            <div class="px-6 py-4 bg-slate-50/30 border-t border-gray-50 flex items-center justify-between flex-wrap gap-4">
                <span class="text-xs font-semibold text-gray-400">
                    @if($suratKeluar->isNotEmpty())
                        Menampilkan {{ $suratKeluar->firstItem() }} sampai {{ $suratKeluar->lastItem() }} dari {{ $suratKeluar->total() }} data
                    @else
                        Menampilkan 5 dari 124 data
                    @endif
                </span>

                <div class="flex items-center gap-1.5">
                    @if($suratKeluar->isNotEmpty())
                        {{ $suratKeluar->links() }}
                    @else
                        <!-- Mock Pagination mimicking mockup visual style -->
                        <button type="button" class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-semibold border border-gray-200 text-gray-400 hover:bg-gray-50 transition cursor-default">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button type="button" class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold bg-blue-600 text-white transition">1</button>
                        <button type="button" class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-semibold border border-transparent text-gray-500 hover:bg-gray-50 transition">2</button>
                        <button type="button" class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-semibold border border-transparent text-gray-500 hover:bg-gray-50 transition">3</button>
                        <span class="w-8 h-8 flex items-center justify-center text-sm font-semibold text-gray-400">...</span>
                        <button type="button" class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-semibold border border-gray-200 text-gray-500 hover:bg-gray-50 transition">25</button>
                        <button type="button" class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-semibold border border-gray-200 text-gray-500 hover:bg-gray-50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Custom Delete Confirmation Modal -->
        <div x-show="deleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-slate-900/30 backdrop-blur-sm transition-opacity" @click="deleteModalOpen = false"></div>
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div x-show="deleteModalOpen" x-transition class="relative transform overflow-hidden rounded-2xl bg-white p-8 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100 flex flex-col items-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-amber-50 text-amber-500 mb-6">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="text-center space-y-4 w-full">
                        <h3 class="text-2xl font-black text-gray-900 uppercase tracking-wide">Apakah Anda Yakin?</h3>
                        <div class="h-0.5 bg-gray-100 w-full my-4"></div>
                        <p class="text-sm text-gray-500 leading-relaxed font-medium">
                            Data yang dihapus tidak dapat dikembalikan. Seluruh riwayat disposisi dan lampiran surat <span class="font-bold text-gray-900" x-text="deleteNomorSurat"></span> akan terhapus secara permanen dari sistem administrasi.
                        </p>
                    </div>
                    <div class="flex items-center justify-center gap-4 mt-8 w-full">
                        <button type="button" @click="deleteModalOpen = false" class="flex-1 border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-bold py-3.5 px-6 rounded-xl text-sm transition duration-150 shadow-sm text-center">
                            BATAL
                        </button>
                        <form :action="deleteActionUrl" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-[#111827] hover:bg-black text-white font-bold py-3.5 px-6 rounded-xl text-sm transition duration-150 shadow-sm text-center uppercase">
                                YA, HAPUS DATA
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
