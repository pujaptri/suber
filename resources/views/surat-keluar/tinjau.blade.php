<x-app-layout>
    @section('title', 'Tinjauan Surat')

    <div class="space-y-6" x-data="{ approveModalOpen: false, rejectModalOpen: false }">
        <!-- Success/Error Flash Toast Notification -->
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

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition class="bg-white border border-red-200 rounded-xl p-4 shadow-sm flex items-center justify-between gap-3 max-w-md mx-auto relative z-50">
                <div class="flex items-center gap-2.5">
                    <div class="w-6 h-6 rounded-full bg-red-50 text-red-600 flex items-center justify-center font-bold text-xs shrink-0">
                        !
                    </div>
                    <span class="text-sm font-semibold text-red-700">{{ session('error') }}</span>
                </div>
                <button type="button" @click="show = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Header with Back Button and Status -->
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('surat-keluar.index') }}" class="inline-flex items-center gap-2 border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-semibold py-2 px-4 rounded-xl text-sm transition duration-150 shadow-sm bg-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
            <div>
                <span class="inline-block border border-gray-300 text-gray-700 bg-white font-extrabold text-xs uppercase px-4 py-2 rounded-lg tracking-wider">
                    STATUS: PENDING
                </span>
            </div>
        </div>

        <!-- Main Layout Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: The Letter sheet (Col span 2) -->
            <div class="lg:col-span-2">
                <div class="bg-white border border-gray-200 rounded-lg p-10 md:p-14 shadow-sm hover:shadow-md transition duration-200 relative min-h-[840px] flex flex-col justify-between">
                    <!-- Letter Top Section -->
                    <div>
                        <!-- Letterhead -->
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex items-center gap-4">
                                <div class="border-2 border-black w-14 h-14 flex items-center justify-center font-extrabold text-3xl">
                                    P
                                </div>
                                <div class="flex flex-col">
                                    <h4 class="text-base font-bold text-gray-900 leading-tight tracking-wide">PT XYZ</h4>
                                    <span class="text-xs text-gray-400 font-bold tracking-wider mt-0.5">Project Management Office</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <h4 class="text-sm font-bold text-gray-900">{{ $surat->nomor_surat }}</h4>
                                <span class="text-xs text-gray-400 font-semibold block mt-1">Jakarta, {{ $surat->tanggal_surat->locale('id')->isoFormat('D MMMM Y') }}</span>
                            </div>
                        </div>

                        <!-- Solid divider line -->
                        <div class="h-0.5 bg-black w-full mb-8"></div>

                        <!-- Letter meta info -->
                        <div class="grid grid-cols-[80px_1fr] gap-y-2 mb-8 text-sm text-gray-800">
                            <div class="font-bold text-gray-400 uppercase tracking-wider">Kepada:</div>
                            <div class="font-bold text-gray-800">{{ $surat->penerima }}</div>
                            <div class="font-bold text-gray-400 uppercase tracking-wider">Perihal:</div>
                            <div class="font-extrabold text-gray-900 uppercase tracking-wider">{{ $surat->perihal ?? '-' }}</div>
                            <div class="font-bold text-gray-400 uppercase tracking-wider">Sifat:</div>
                            <div class="italic text-gray-600 font-bold capitalize">{{ str_replace('_', ' ', $surat->sifat_surat) }}</div>
                        </div>

                        <!-- Letter Body -->
                        <div class="text-sm text-gray-750 leading-relaxed space-y-4 font-medium whitespace-pre-line">
                            {{ $surat->isi_surat }}
                        </div>
                    </div>

                    <!-- Signature block & Attachment footer -->
                    <div>
                        <!-- Signature block (Right aligned) -->
                        <div class="flex flex-col items-center ml-auto w-64 text-center mt-16 mb-12">
                            <p class="text-xs text-gray-400 italic font-semibold mb-6">tanda tangan</p>
                            <div class="h-px bg-gray-400 w-full mb-3"></div>
                            <p class="text-sm font-extrabold text-gray-900 uppercase tracking-wide">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400 font-semibold mt-1">Super Admin · PT XYZ</p>
                        </div>

                        <div class="border-t border-gray-100 pt-6">
                            <a href="{{ $surat->lampiran ? '/storage/' . $surat->lampiran : '#' }}" target="_blank" class="inline-flex items-center gap-2 text-xs font-bold text-gray-850 hover:text-blue-600 uppercase tracking-wider transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lampiran Dokumen
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar Actions & Info -->
            <div class="space-y-6">
                <!-- Widget 1: Tindakan Pimpinan -->
                <div class="bg-white border-2 border-black rounded-xl p-6 shadow-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="text-gray-850">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h4 class="text-xs font-bold text-gray-850 uppercase tracking-wider">Tindakan Pimpinan</h4>
                    </div>

                    <p class="text-xs text-gray-450 leading-relaxed font-semibold">
                        Tinjau isi dan lampiran surat dengan seksama sebelum memberikan keputusan persetujuan.
                    </p>

                    <!-- Large Action Buttons -->
                    <div class="space-y-3 mt-6">
                        <!-- Setujui Surat -->
                        <button type="button" @click="approveModalOpen = true" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl text-sm transition duration-150 shadow-sm text-center flex items-center justify-center gap-2 uppercase tracking-wide">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Setujui Surat
                        </button>

                        <!-- Tolak & Beri Catatan -->
                        <button type="button" @click="rejectModalOpen = true" class="w-full bg-white hover:bg-gray-50 border border-gray-200 text-gray-800 font-bold py-3.5 px-4 rounded-xl text-sm transition duration-150 shadow-sm text-center flex items-center justify-center gap-2 uppercase tracking-wide">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Tolak & Beri Catatan
                        </button>
                    </div>
                </div>

                <!-- Widget 2: Antrian Persetujuan -->
                <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Antrian Persetujuan</h4>
                    </div>

                    <div class="flex items-center justify-between text-xs font-semibold">
                        <span class="text-gray-400">{{ $totalPending }} surat menunggu</span>
                        <span class="text-gray-800">{{ $currentQueueNumber }} dari {{ $totalPending }}</span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden mt-3">
                        <div class="bg-blue-600 h-full transition-all duration-350" style="width: {{ $totalPending > 0 ? ($currentQueueNumber / $totalPending) * 100 : 100 }}%"></div>
                    </div>
                </div>

                <!-- Widget 3: Informasi Pengajuan -->
                <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm space-y-4">
                    <div class="flex items-center gap-2 border-b border-gray-50 pb-3">
                        <div class="text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Informasi Pengajuan</h4>
                    </div>

                    <!-- User Avatar block -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded bg-slate-100 text-gray-800 flex items-center justify-center font-bold text-sm uppercase shrink-0">
                            {{ strtoupper(substr($surat->user->name ?? 'OP', 0, 2)) }}
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-gray-800 leading-tight">{{ $surat->user->name ?? 'Staf Admin' }}</span>
                            <span class="text-[10px] font-bold text-gray-400 tracking-wider uppercase mt-1">Admin Pengaju</span>
                        </div>
                    </div>

                    <!-- Grid Metadata details -->
                    <div class="grid grid-cols-2 gap-4 pt-2 border-t border-gray-50 text-[11px] font-semibold leading-relaxed">
                        <div class="space-y-1">
                            <span class="text-gray-400 block uppercase tracking-wider">Kategori</span>
                            <span class="text-gray-800 font-bold text-xs uppercase tracking-wide">{{ $surat->kategori }}</span>
                        </div>
                        <div class="space-y-1">
                            <span class="text-gray-400 block uppercase tracking-wider">Diajukan Pada</span>
                            <span class="text-gray-800 font-bold text-xs whitespace-nowrap">{{ $surat->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approve Modal -->
        <div x-show="approveModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-slate-900/30 backdrop-blur-sm transition-opacity" @click="approveModalOpen = false"></div>
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div x-show="approveModalOpen" x-transition class="relative transform overflow-hidden rounded-2xl bg-white p-8 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100 flex flex-col items-center">
                    <!-- Modal Header -->
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-50 text-green-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1 text-center uppercase tracking-wide">Persetujuan Surat</h3>
                    <p class="text-xs text-gray-500 text-center mb-6">Berikan keputusan persetujuan untuk surat ini.</p>
                    
                    <form action="{{ route('surat-keluar.setujui', $surat->id) }}" method="POST" class="w-full space-y-4">
                        @csrf
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Catatan Setuju (Opsional)</label>
                            <textarea name="catatan" rows="3" placeholder="Disetujui..." class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl p-3 text-sm text-gray-700 transition"></textarea>
                        </div>
                        <div class="flex items-center gap-3 pt-2">
                            <button type="button" @click="approveModalOpen = false" class="flex-1 border border-gray-200 text-gray-650 hover:text-gray-900 hover:bg-gray-50 font-bold py-3.5 px-4 rounded-xl text-xs transition uppercase tracking-wider text-center">
                                Batal
                            </button>
                            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl text-xs transition uppercase tracking-wider text-center shadow-sm">
                                Setujui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div x-show="rejectModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-slate-900/30 backdrop-blur-sm transition-opacity" @click="rejectModalOpen = false"></div>
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div x-show="rejectModalOpen" x-transition class="relative transform overflow-hidden rounded-2xl bg-white p-8 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100 flex flex-col items-center">
                    <!-- Modal Header -->
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-50 text-red-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1 text-center uppercase tracking-wide">Tolak & Beri Catatan</h3>
                    <p class="text-xs text-gray-500 text-center mb-6">Tolak surat atau minta revisi dengan memberikan catatan revisi yang jelas.</p>
                    
                    <form action="{{ route('surat-keluar.tolak', $surat->id) }}" method="POST" class="w-full space-y-4">
                        @csrf
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Catatan Penolakan/Revisi (Wajib)</label>
                            <textarea name="catatan" required rows="3" placeholder="Tolong perbaiki format tanggal / nomor surat..." class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl p-3 text-sm text-gray-700 transition"></textarea>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Tindakan Keputusan</label>
                            <select name="keputusan" required class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl p-3 text-sm text-gray-750 transition cursor-pointer">
                                <option value="revisi">Minta Revisi</option>
                                <option value="ditolak">Tolak Surat</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-3 pt-2">
                            <button type="button" @click="rejectModalOpen = false" class="flex-1 border border-gray-200 text-gray-650 hover:text-gray-900 hover:bg-gray-50 font-bold py-3.5 px-4 rounded-xl text-xs transition uppercase tracking-wider text-center">
                                Batal
                            </button>
                            <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 px-4 rounded-xl text-xs transition uppercase tracking-wider text-center shadow-sm">
                                Kirim Keputusan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
