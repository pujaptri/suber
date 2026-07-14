<x-app-layout>
    @section('title', 'Detail Surat Masuk')

    @php
        $isMock = ($surat->nomor_surat === '03/SM-ADM/2026') || (!$surat->exists);
        
        // Define sifat_surat badge classes
        $sifat = strtolower($surat->sifat_surat);
        if ($sifat === 'penting') {
            $badgeColor = 'bg-amber-50 text-amber-600 border border-amber-100';
            $badgeText = 'PENTING';
        } elseif ($sifat === 'rahasia' || $sifat === 'sangat_rahasia') {
            $badgeColor = 'bg-red-50 text-red-600 border border-red-100';
            $badgeText = strtoupper(str_replace('_', ' ', $sifat));
        } else {
            $badgeColor = 'bg-blue-50 text-blue-600 border border-blue-100';
            $badgeText = 'BIASA';
        }
    @endphp

    <div class="space-y-6" x-data="{ previewModalOpen: false, previewUrl: '', previewType: '', previewTitle: '' }">
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

        <!-- Header with Back Button -->
        <div class="flex items-center gap-4">
            <a href="{{ route('surat-masuk.index') }}" class="inline-flex items-center gap-2 border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-semibold py-2 px-4 rounded-xl text-sm transition duration-150 shadow-sm bg-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Main Layout Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Side Details Card & Activity (Col-span 2) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Detail Surat Card -->
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-200 relative">
                    <!-- Badge Sifat Surat -->
                    <div class="absolute top-6 right-6">
                        <span class="text-xs font-bold px-3 py-1 rounded-lg {{ $badgeColor }}">
                            {{ $badgeText }}
                        </span>
                    </div>

                    <!-- Nomor Surat -->
                    <div class="space-y-1 mb-6">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nomor Surat</span>
                        <h3 class="text-3xl font-extrabold text-gray-900 mt-1 leading-tight">{{ $surat->nomor_surat }}</h3>
                        <p class="text-sm text-gray-500 font-medium">Diterima: {{ $surat->tanggal_diterima->locale('id')->isoFormat('DD MMM Y') }}</p>
                    </div>

                    <div class="h-px bg-gray-100 my-6"></div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8 mb-6">
                        <!-- Pengirim -->
                        <div class="space-y-1.5">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Pengirim</span>
                            <span class="text-base font-bold text-gray-800 block">
                                {{ $surat->asal_surat }}
                            </span>
                            <span class="text-sm text-gray-500 font-medium block">
                                Instansi / Organisasi Pengirim
                            </span>
                        </div>

                        <!-- Penerima -->
                        <div class="space-y-1.5">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Penerima</span>
                            <span class="text-base font-bold text-gray-800 block">
                                {{ $surat->penerima ?? 'Penerima Surat' }}
                            </span>
                            <span class="text-sm text-gray-500 font-medium block">
                                Nama Jabatan / Penerima Surat
                            </span>
                        </div>

                        <!-- Bagian -->
                        <div class="space-y-1.5">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Bagian</span>
                            <span class="text-base font-bold text-gray-800 block">
                                {{ $surat->bagian ?? 'Bagian / Departemen' }}
                            </span>
                            <span class="text-sm text-gray-500 font-medium block">
                                Unit Kerja Penerima
                            </span>
                        </div>
                    </div>

                    <div class="h-px bg-gray-100 my-6"></div>

                    <!-- Kategori & Perihal -->
                    <div class="space-y-4">
                        <div class="space-y-1.5">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Kategori & Perihal</span>
                            <h4 class="text-lg font-bold text-gray-800 capitalize">{{ str_replace('_', ' ', $surat->kategori) }}</h4>
                        </div>
                        <div class="bg-blue-50/40 border-l-4 border-blue-600 p-4 rounded-r-xl italic text-gray-600 text-sm leading-relaxed font-medium">
                            "{{ $surat->perihal ?? '-' }}"
                        </div>
                    </div>
                </div>

                <!-- Riwayat Aktivitas Card -->
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-200">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-50 mb-6">
                        <h4 class="text-lg font-bold text-gray-800">Riwayat Aktivitas</h4>
                        <div class="text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Timeline layout -->
                    <div class="relative pl-6 space-y-6 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-px before:bg-gray-100">
                        <!-- Timeline Item 1 (Blue dot) -->
                        <div class="relative">
                            <div class="absolute -left-6 top-1.5 w-4.5 h-4.5 rounded-full bg-white border-4 border-blue-600"></div>
                            <div class="space-y-1">
                                <h5 class="text-sm font-bold text-gray-800">Surat Diterima</h5>
                                <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">
                                    {{ $surat->created_at->locale('id')->isoFormat('DD MMM Y • HH:mm') }} oleh {{ $surat->user->name ?? 'Admin' }}
                                </p>
                            </div>
                        </div>

                        <!-- Timeline Item 2 (Muted outline dot) -->
                        <div class="relative">
                            <div class="absolute -left-6 top-1.5 w-4.5 h-4.5 rounded-full bg-white border-4 border-gray-200"></div>
                            <div class="space-y-1">
                                <h5 class="text-sm font-bold text-gray-400">Menunggu Tindak Lanjut</h5>
                                <p class="text-xs text-gray-400 italic">Belum ada tindak lanjut</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side Widgets (Col-span 1) -->
            <div class="space-y-6">
                <!-- Lampiran Widget -->
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-200">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-50 mb-4">
                        <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Lampiran Dokumen</h4>
                        <div class="text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Files list -->
                    <div class="space-y-3">
                        @if($surat->lampiran)
                            @php
                                $fileName = preg_replace('/^\d+_/', '', basename($surat->lampiran));
                                $isPdf = str_contains(strtolower($fileName), '.pdf');
                                $isImage = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $fileName);
                                $fileIconColor = $isPdf ? 'text-red-500 bg-red-50' : ($isImage ? 'text-green-500 bg-green-50' : 'text-blue-500 bg-blue-50');
                                $fileTypeLabel = $isPdf ? 'PDF' : ($isImage ? 'IMG' : 'FILE');
                            @endphp
                            <!-- Real Attachment -->
                            <div class="flex items-center justify-between p-3 border border-gray-100 rounded-xl hover:bg-slate-50/50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center font-bold text-xs shrink-0 {{ $fileIconColor }}">
                                        {{ $fileTypeLabel }}
                                    </div>
                                    <div class="min-w-0">
                                        <h5 class="text-sm font-bold text-gray-800 truncate max-w-[100px]">{{ $fileName }}</h5>
                                        <p class="text-[11px] font-semibold text-gray-400">{{ $fileTypeLabel }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1 shrink-0">
                                    <!-- Preview Button -->
                                    <button type="button" @click.prevent="previewModalOpen = true; previewUrl = '/storage/{{ $surat->lampiran }}'; previewType = '{{ $isPdf ? 'pdf' : ($isImage ? 'image' : 'other') }}'; previewTitle = '{{ $fileName }}';" class="text-gray-400 hover:text-blue-600 p-1 rounded-lg hover:bg-gray-50 transition" title="Pratinjau">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    <!-- Download Button -->
                                    <a href="/storage/{{ $surat->lampiran }}" download class="text-gray-400 hover:text-blue-600 p-1 rounded-lg hover:bg-gray-50 transition" title="Unduh">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if(!$surat->lampiran)
                            <div class="flex items-center justify-center p-4 border border-dashed border-gray-100 rounded-xl bg-gray-50/50 text-center">
                                <span class="text-xs font-semibold text-gray-400">Tidak ada lampiran</span>
                            </div>
                        @endif
                    </div>

                    <!-- Add Attachment placeholder -->
                    <button type="button" class="w-full mt-4 border border-dashed border-gray-200 text-blue-600 hover:bg-blue-50 font-bold py-3.5 px-4 rounded-xl text-xs tracking-wider transition duration-150 text-center uppercase flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Lampiran
                    </button>
                </div>

                <!-- Petugas Input Widget -->
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-200">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 block">PETUGAS INPUT</span>
                    
                    <div class="flex items-center gap-3.5 p-3 border border-gray-100 rounded-xl">
                        <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-700 font-bold flex items-center justify-center border border-blue-100 shrink-0">
                            {{ strtoupper(substr($surat->user->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-gray-800 leading-none">{{ $surat->user->name ?? 'Admin Pusat' }}</span>
                            <span class="text-xs font-medium text-gray-400 mt-1">{{ ($surat->user->role ?? '') === 'superadmin' ? 'Superadmin' : 'Staf Administrasi' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Tindakan Cepat Widget -->
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-200">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 block">TINDAKAN CEPAT</span>
                    
                    <div class="space-y-3">
                        <!-- Edit Button -->
                        <a href="{{ route('surat-masuk.edit', $surat->id) }}" class="w-full inline-flex items-center justify-center gap-2 border border-blue-600 text-blue-600 hover:bg-blue-50 font-bold py-3.5 px-4 rounded-xl text-sm transition duration-150 shadow-sm text-center uppercase">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            Edit Data
                        </a>

                        <!-- Delete Button -->
                        <form action="{{ route('surat-masuk.destroy', $surat->id) }}" method="POST" class="w-full" onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 border border-red-600 text-red-600 hover:bg-red-50 font-bold py-3.5 px-4 rounded-xl text-sm transition duration-150 shadow-sm text-center uppercase">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Preview Modal -->
        <div x-show="previewModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" @click="previewModalOpen = false"></div>
            
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div x-show="previewModalOpen" x-transition class="relative transform overflow-hidden rounded-2xl bg-white p-6 text-left shadow-2xl transition-all sm:my-8 w-full max-w-5xl border border-gray-100 flex flex-col h-[85vh]">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 shrink-0">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 tracking-tight" x-text="previewTitle">Pratinjau Dokumen</h3>
                                <p class="text-xs text-gray-400 font-medium">Dokumen lampiran surat resmi</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <!-- Download button inside modal -->
                            <a :href="previewUrl || '#'" download x-show="previewUrl" class="inline-flex items-center gap-2 border border-gray-200 text-gray-650 hover:text-gray-900 hover:bg-gray-50 font-bold py-2 px-4 rounded-xl text-xs uppercase transition shadow-sm bg-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Unduh
                            </a>
                            <!-- Close button -->
                            <button type="button" @click="previewModalOpen = false" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Modal Body / Content (Scrollable/Flex fill) -->
                    <div class="flex-1 overflow-y-auto bg-slate-50 rounded-xl p-4 mt-4 flex items-center justify-center border border-gray-100 min-h-0">
                        <!-- PDF Preview -->
                        <template x-if="previewType === 'pdf'">
                            <iframe :src="previewUrl" class="w-full h-full rounded-lg border-0 bg-white" type="application/pdf"></iframe>
                        </template>

                        <!-- Image Preview -->
                        <template x-if="previewType === 'image'">
                            <img :src="previewUrl" class="max-w-full max-h-full object-contain rounded-lg shadow-sm" alt="Preview">
                        </template>

                        <!-- Mock PDF Viewer -->
                        <template x-if="previewType === 'mock_pdf'">
                            <div class="w-full max-w-2xl bg-white shadow-lg rounded-xl p-8 md:p-12 border border-gray-200 text-gray-800 flex flex-col font-serif aspect-[1/1.4] overflow-y-auto">
                                <!-- Letterhead Mock -->
                                <div class="text-center space-y-2 border-b-2 border-double border-gray-800 pb-4 mb-6 shrink-0">
                                    <h4 class="text-base md:text-lg font-bold uppercase tracking-wider leading-none">Kementerian Perhubungan Republik Indonesia</h4>
                                    <p class="text-[9px] font-sans text-gray-500">Jl. Medan Merdeka Barat No. 8, Jakarta Pusat | Telp: (021) 3811308</p>
                                </div>
                                <!-- Content Mock -->
                                <div class="flex justify-between text-[11px] font-sans text-gray-500 mb-6 shrink-0">
                                    <div class="space-y-1">
                                        <p><span class="font-bold">Nomor :</span> 045/SK/XII/2024</p>
                                        <p><span class="font-bold">Sifat :</span> Penting</p>
                                        <p><span class="font-bold">Lampiran :</span> 1 Berkas</p>
                                    </div>
                                    <p class="text-right">Jakarta, 12 Desember 2024</p>
                                </div>
                                <div class="space-y-4 text-xs leading-relaxed font-serif flex-1">
                                    <p class="font-bold font-sans">Kepada Yth.<br>Kepala Biro Perencanaan<br>di Tempat</p>
                                    <p class="font-bold font-sans mt-4">Perihal: Undangan Rapat Koordinasi Teknis</p>
                                    <p class="indent-8 text-justify">Dengan hormat, sehubungan dengan pelaksanaan program kerja tahun anggaran 2024/2025, kami mengharap kehadiran Saudara dalam rapat koordinasi teknis yang akan membahas evaluasi triwulan IV serta sinkronisasi program prioritas nasional.</p>
                                    <p class="indent-8 text-justify">Rapat koordinasi teknis tersebut rencananya akan diselenggarakan pada hari Selasa tanggal 16 Desember 2024 bertempat di Ruang Rapat Utama Gedung Karya Lantai 2, Kementerian Perhubungan.</p>
                                    <p class="indent-8 text-justify">Demikian undangan ini kami sampaikan. Mengingat pentingnya materi pembahasan, kehadiran Saudara sangat kami harapkan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
                                </div>
                                <!-- Footer Signature Mock -->
                                <div class="mt-8 flex justify-end font-sans shrink-0">
                                    <div class="text-center space-y-1 text-xs">
                                        <p>Sekretaris Jenderal,</p>
                                        <div class="py-2 flex justify-center">
                                            <!-- Mock Stamp / QR -->
                                            <div class="border border-blue-200 bg-blue-50/50 p-2 rounded-lg text-center flex flex-col items-center gap-1 opacity-70">
                                                <div class="w-10 h-10 bg-blue-600 rounded flex items-center justify-center text-white font-bold text-[8px] uppercase">QR Code</div>
                                                <span class="text-[7px] text-blue-600 font-bold font-mono">Verified TTE</span>
                                            </div>
                                        </div>
                                        <p class="font-bold underline">Dr. Ir. Sugihardjo, M.Si</p>
                                        <p class="text-[10px] text-gray-400">NIP. 19610815 198703 1 001</p>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Mock XLSX Viewer -->
                        <template x-if="previewType === 'mock_xlsx'">
                            <div class="w-full h-full bg-white rounded-xl shadow-inner border border-gray-200 overflow-auto flex flex-col">
                                <!-- Mock Sheets bar -->
                                <div class="bg-slate-100 px-4 py-2 border-b border-gray-200 flex items-center gap-2 text-xs font-sans text-gray-600 shrink-0">
                                    <span class="font-bold text-gray-800">File: Lampiran_Anggaran.xlsx</span>
                                    <div class="h-4 w-px bg-gray-200 mx-2"></div>
                                    <span class="bg-white px-2 py-0.5 border border-gray-200 rounded text-blue-600 font-semibold">Sheet1</span>
                                    <span class="hover:bg-gray-200 px-2 py-0.5 rounded transition cursor-pointer">Sheet2</span>
                                </div>
                                <!-- Excel Grid Layout Mock -->
                                <div class="flex-1 p-4 font-mono text-[11px] text-gray-700 min-w-[600px]">
                                    <table class="w-full border-collapse border border-gray-300">
                                        <thead>
                                            <tr class="bg-slate-50 text-gray-500">
                                                <th class="border border-gray-300 py-1.5 px-2 w-10 text-center font-sans"></th>
                                                <th class="border border-gray-300 py-1.5 px-2 text-center font-sans">A</th>
                                                <th class="border border-gray-300 py-1.5 px-2 text-center font-sans">B</th>
                                                <th class="border border-gray-300 py-1.5 px-2 text-center font-sans">C</th>
                                                <th class="border border-gray-300 py-1.5 px-2 text-center font-sans">D</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Row 1 -->
                                            <tr>
                                                <td class="border border-gray-300 bg-slate-50 font-sans text-gray-400 font-bold py-1.5 px-2 text-center w-10">1</td>
                                                <td class="border border-gray-300 py-1.5 px-2 font-bold font-sans text-gray-800" colspan="4">DAFTAR REKAPITULASI RENCANA ANGGARAN BIAYA (RAB) TA 2024/2025</td>
                                            </tr>
                                            <!-- Row 2 -->
                                            <tr>
                                                <td class="border border-gray-300 bg-slate-50 font-sans text-gray-400 font-bold py-1.5 px-2 text-center w-10">2</td>
                                                <td class="border border-gray-300 py-1.5 px-2 bg-slate-50 font-bold font-sans">No</td>
                                                <td class="border border-gray-300 py-1.5 px-2 bg-slate-50 font-bold font-sans">Uraian Pekerjaan</td>
                                                <td class="border border-gray-300 py-1.5 px-2 bg-slate-50 font-bold font-sans text-right">Volume</td>
                                                <td class="border border-gray-300 py-1.5 px-2 bg-slate-50 font-bold font-sans text-right">Jumlah Total (Rp)</td>
                                            </tr>
                                            <!-- Row 3 -->
                                            <tr>
                                                <td class="border border-gray-300 bg-slate-50 font-sans text-gray-400 font-bold py-1.5 px-2 text-center w-10">3</td>
                                                <td class="border border-gray-300 py-1.5 px-2">1</td>
                                                <td class="border border-gray-300 py-1.5 px-2 font-sans">Belanja Pengadaan Perangkat Komputer (PC/Laptop)</td>
                                                <td class="border border-gray-300 py-1.5 px-2 text-right">15 Unit</td>
                                                <td class="border border-gray-300 py-1.5 px-2 text-right">225.000.000</td>
                                            </tr>
                                            <!-- Row 4 -->
                                            <tr>
                                                <td class="border border-gray-300 bg-slate-50 font-sans text-gray-400 font-bold py-1.5 px-2 text-center w-10">4</td>
                                                <td class="border border-gray-300 py-1.5 px-2">2</td>
                                                <td class="border border-gray-300 py-1.5 px-2 font-sans">Penyelenggaraan Sosialisasi Kearsipan Digital</td>
                                                <td class="border border-gray-300 py-1.5 px-2 text-right">2 Paket</td>
                                                <td class="border border-gray-300 py-1.5 px-2 text-right">45.000.000</td>
                                            </tr>
                                            <!-- Row 5 -->
                                            <tr>
                                                <td class="border border-gray-300 bg-slate-50 font-sans text-gray-400 font-bold py-1.5 px-2 text-center w-10">5</td>
                                                <td class="border border-gray-300 py-1.5 px-2">3</td>
                                                <td class="border border-gray-300 py-1.5 px-2 font-sans">Pemeliharaan Server & Database Lokal (1 Tahun)</td>
                                                <td class="border border-gray-300 py-1.5 px-2 text-right">1 Keg</td>
                                                <td class="border border-gray-300 py-1.5 px-2 text-right">72.000.000</td>
                                            </tr>
                                            <!-- Row 6 -->
                                            <tr>
                                                <td class="border border-gray-300 bg-slate-50 font-sans text-gray-400 font-bold py-1.5 px-2 text-center w-10">6</td>
                                                <td class="border border-gray-300 py-1.5 px-2">4</td>
                                                <td class="border border-gray-300 py-1.5 px-2 font-sans">Penggandaan Dokumen Administrasi & ATK Biro</td>
                                                <td class="border border-gray-300 py-1.5 px-2 text-right">12 Bln</td>
                                                <td class="border border-gray-300 py-1.5 px-2 text-right">18.000.000</td>
                                            </tr>
                                            <!-- Row 7 -->
                                            <tr class="bg-slate-50/50">
                                                <td class="border border-gray-300 bg-slate-50 font-sans text-gray-400 font-bold py-1.5 px-2 text-center w-10">7</td>
                                                <td class="border border-gray-300 py-1.5 px-2 font-bold font-sans" colspan="3">Jumlah Total Anggaran</td>
                                                <td class="border border-gray-300 py-1.5 px-2 font-bold text-right text-blue-600">360.000.000</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </template>

                        <!-- Unknown/Other Preview -->
                        <template x-if="previewType === 'other'">
                            <div class="text-center p-8 space-y-4">
                                <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center mx-auto">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-base font-bold text-gray-800">Pratinjau Tidak Tersedia</h4>
                                <p class="text-sm text-gray-400 max-w-xs mx-auto">Format berkas ini tidak dapat ditampilkan secara langsung. Silakan unduh berkas untuk melihat konten.</p>
                            </div>
                        </template>
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
