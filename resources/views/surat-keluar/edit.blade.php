<x-app-layout>
    @section('title', 'Edit Surat Keluar')

    <div class="space-y-6">
        <!-- Header with Back Button -->
        <div class="flex items-center gap-4">
            <a href="{{ route('surat-keluar.show', $surat->id) }}" class="inline-flex items-center gap-2 border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-semibold py-2 px-4 rounded-xl text-sm transition duration-150 shadow-sm bg-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Form Card Container -->
        <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm hover:shadow-md transition duration-200">
            <form action="{{ route('surat-keluar.update', $surat->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- 2-Column Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nomor Surat -->
                    <div class="space-y-1.5">
                        <label for="nomor_surat" class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Nomor Surat <span class="text-red-500">*</span></label>
                        <input type="text" name="nomor_surat" id="nomor_surat" value="{{ old('nomor_surat', $surat->nomor_surat) }}" required class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-3 px-4 text-sm text-gray-700 transition">
                        @error('nomor_surat')
                            <span class="text-xs text-red-500 font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Kategori Surat -->
                    <div class="space-y-1.5">
                        <label for="kategori" class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Kategori Surat <span class="text-red-500">*</span></label>
                        <select name="kategori" id="kategori" required class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-3 px-4 text-sm text-gray-700 transition cursor-pointer">
                            <option value="internal" {{ old('kategori', $surat->kategori) == 'internal' ? 'selected' : '' }}>Internal (Dinas)</option>
                            <option value="eksternal" {{ old('kategori', $surat->kategori) == 'eksternal' ? 'selected' : '' }}>Eksternal</option>
                            <option value="undangan" {{ old('kategori', $surat->kategori) == 'undangan' ? 'selected' : '' }}>Undangan</option>
                            <option value="pemberitahuan" {{ old('kategori', $surat->kategori) == 'pemberitahuan' ? 'selected' : '' }}>Pemberitahuan</option>
                            <option value="lainnya" {{ old('kategori', $surat->kategori) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('kategori')
                            <span class="text-xs text-red-500 font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tanggal Surat -->
                    <div class="space-y-1.5">
                        <label for="tanggal_surat" class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Tanggal Surat <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_surat" id="tanggal_surat" value="{{ old('tanggal_surat', $surat->tanggal_surat->format('Y-m-d')) }}" required class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-2.5 px-4 text-sm text-gray-700 transition">
                        @error('tanggal_surat')
                            <span class="text-xs text-red-500 font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Sifat Surat -->
                    <div class="space-y-1.5">
                        <label for="sifat_surat" class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Sifat Surat <span class="text-red-500">*</span></label>
                        <select name="sifat_surat" id="sifat_surat" required class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-3 px-4 text-sm text-gray-700 transition cursor-pointer">
                            <option value="biasa" {{ old('sifat_surat', $surat->sifat_surat) == 'biasa' ? 'selected' : '' }}>Biasa</option>
                            <option value="penting" {{ old('sifat_surat', $surat->sifat_surat) == 'penting' ? 'selected' : '' }}>Penting</option>
                            <option value="rahasia" {{ old('sifat_surat', $surat->sifat_surat) == 'rahasia' ? 'selected' : '' }}>Rahasia</option>
                            <option value="sangat_rahasia" {{ old('sifat_surat', $surat->sifat_surat) == 'sangat_rahasia' ? 'selected' : '' }}>Sangat Rahasia</option>
                        </select>
                        @error('sifat_surat')
                            <span class="text-xs text-red-500 font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Penerima Surat -->
                    <div class="space-y-1.5 md:col-span-2">
                        <label for="penerima" class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Penerima Surat <span class="text-red-500">*</span></label>
                        <input type="text" name="penerima" id="penerima" value="{{ old('penerima', $surat->penerima) }}" required class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-3 px-4 text-sm text-gray-700 transition">
                        @error('penerima')
                            <span class="text-xs text-red-500 font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Perihal (textarea, full width) -->
                <div class="space-y-1.5">
                    <label for="perihal" class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Perihal</label>
                    <textarea name="perihal" id="perihal" rows="3" placeholder="Tuliskan perihal atau judul utama surat..." class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-3 px-4 text-sm text-gray-700 transition leading-relaxed">{{ old('perihal', $surat->perihal) }}</textarea>
                    @error('perihal')
                        <span class="text-xs text-red-500 font-semibold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Isi Surat (textarea, full width) -->
                <div class="space-y-1.5">
                    <label for="isi_surat" class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Isi Ringkas Surat</label>
                    <textarea name="isi_surat" id="isi_surat" rows="5" class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-3 px-4 text-sm text-gray-700 transition leading-relaxed">{{ old('isi_surat', $surat->isi_surat) }}</textarea>
                    @error('isi_surat')
                        <span class="text-xs text-red-500 font-semibold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Keterangan (textarea, full width) -->
                <div class="space-y-1.5">
                    <label for="keterangan" class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Keterangan Tambahan</label>
                    <textarea name="keterangan" id="keterangan" rows="2" class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-3 px-4 text-sm text-gray-700 transition leading-relaxed">{{ old('keterangan', $surat->keterangan) }}</textarea>
                    @error('keterangan')
                        <span class="text-xs text-red-500 font-semibold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Unggah Berkas Area -->
                <div class="space-y-3" x-data="{ fileName: '', fileSize: '', hasFile: false, isDeleted: false, fileExtension: '{{ $surat->lampiran ? strtoupper(pathinfo($surat->lampiran, PATHINFO_EXTENSION)) : 'PDF' }}', isDragging: false, fileUrl: '{{ $surat->lampiran ? '/storage/' . $surat->lampiran : '' }}' }">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Unggah Lampiran Dokumen Baru <span class="text-red-500">*</span></span>
                    
                    <input type="hidden" name="hapus_lampiran" :value="isDeleted ? 1 : 0">

                    <!-- Drag & Drop container -->
                    <label class="w-full border-2 border-dashed transition rounded-2xl py-8 px-4 flex flex-col items-center justify-center cursor-pointer gap-2"
                        :class="isDragging ? 'border-blue-500 bg-blue-50/40 shadow-inner' : 'border-gray-200 hover:border-blue-400 hover:bg-blue-50/20'"
                        @dragover.prevent="isDragging = true"
                        @dragleave.prevent="isDragging = false"
                        @drop.prevent="
                            isDragging = false;
                            if($event.dataTransfer.files.length > 0) {
                                const file = $event.dataTransfer.files[0];
                                const ext = file.name.split('.').pop().toLowerCase();
                                const allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
                                if(allowed.includes(ext)) {
                                    $el.querySelector('input[type=file]').files = $event.dataTransfer.files;
                                    fileName = file.name;
                                    fileSize = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
                                    fileExtension = ext.toUpperCase();
                                    fileUrl = URL.createObjectURL(file);
                                    hasFile = true;
                                    isDeleted = false;
                                } else {
                                    alert('Format file tidak didukung! Hanya diperbolehkan PDF, DOCX, atau XLS.');
                                }
                            }
                        ">
                        <input type="file" name="lampiran" accept=".pdf,.doc,.docx,.xls,.xlsx" class="hidden" @change="
                            if($event.target.files.length > 0) {
                                const file = $event.target.files[0];
                                fileName = file.name;
                                fileSize = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
                                fileExtension = fileName.split('.').pop().toUpperCase();
                                fileUrl = URL.createObjectURL(file);
                                hasFile = true;
                                isDeleted = false;
                            } else {
                                hasFile = false;
                            }
                        ">
                        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-gray-500 pointer-events-none">
                            <!-- Upload cloud SVG -->
                            <svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <div class="text-center pointer-events-none">
                            <p class="text-sm font-semibold text-gray-600">Seret dan lepas berkas baru di sini atau <span class="text-blue-600 font-bold">pilih berkas</span></p>
                            <p class="text-xs text-gray-400 mt-1">Format PDF, DOCX, atau XLS (Maks. 5MB). Biarkan kosong jika tidak ingin mengubah lampiran.</p>
                        </div>
                    </label>

                    @error('lampiran')
                        <span class="text-xs text-red-500 font-semibold block mt-1">{{ $message }}</span>
                    @enderror

                    <!-- Selected File List (either new uploaded file or already uploaded file) -->
                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl bg-slate-50/30" x-show="(hasFile || {{ $surat->lampiran ? 'true' : 'false' }}) && !isDeleted">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center font-bold text-xs shrink-0"
                                :class="{
                                    'text-red-500 bg-red-50': fileExtension === 'PDF',
                                    'text-blue-500 bg-blue-50': ['DOC', 'DOCX'].includes(fileExtension),
                                    'text-emerald-500 bg-emerald-50': ['XLS', 'XLSX'].includes(fileExtension),
                                    'text-gray-500 bg-gray-50': !['PDF', 'DOC', 'DOCX', 'XLS', 'XLSX'].includes(fileExtension)
                                }"
                                x-text="fileExtension">
                                PDF
                            </div>
                            <div class="min-w-0">
                                <h5 class="text-sm font-bold text-gray-800 truncate max-w-[200px]" x-text="hasFile ? fileName : '{{ $surat->lampiran ? preg_replace('/^\d+_/', '', basename($surat->lampiran)) : 'lampiran_surat.pdf' }}'">lampiran_surat.pdf</h5>
                                <p class="text-[11px] font-semibold text-gray-400" x-text="hasFile ? fileSize : '{{ ($surat->lampiran && Storage::disk('public')->exists($surat->lampiran)) ? number_format(Storage::disk('public')->size($surat->lampiran) / (1024 * 1024), 1) . ' MB' : 'Lampiran Aktif' }}'"></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a :href="fileUrl" target="_blank" class="text-gray-400 hover:text-blue-600 p-1.5 rounded-lg hover:bg-gray-50 transition" title="Pratinjau Berkas">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <button type="button" @click="if(hasFile) { fileName = ''; fileSize = ''; hasFile = false; fileUrl = '{{ $surat->lampiran ? '/storage/' . $surat->lampiran : '' }}'; $el.closest('.space-y-3').querySelector('input[type=file]').value = ''; isDeleted = {{ $surat->lampiran ? 'true' : 'false' }}; } else { isDeleted = true; }" class="text-red-500 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-50 transition" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50">
                    <a href="{{ route('surat-keluar.show', $surat->id) }}" class="border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-bold py-3 px-8 rounded-xl text-sm transition duration-150 shadow-sm text-center">
                        Batal
                    </a>
                    <button type="submit" class="bg-[#111827] hover:bg-black text-white font-bold py-3 px-8 rounded-xl text-sm transition duration-150 shadow-sm text-center">
                        Simpan Perubahan
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
