<x-app-layout>
    @section('title', 'Edit Data Pengguna')

    <div class="space-y-6">
        <!-- Header with Back Button -->
        <div class="flex items-center gap-4">
            <a href="{{ route('pengguna.index') }}" class="inline-flex items-center gap-2 border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-semibold py-2 px-4 rounded-xl text-sm transition duration-150 shadow-sm bg-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Form Card Container -->
        <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm hover:shadow-md transition duration-200">
            <form action="{{ route('pengguna.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Lengkap -->
                    <div class="space-y-1.5">
                        <label for="name" class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required placeholder="Contoh: Andi Saputra" class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-3 px-4 text-sm text-gray-700 transition">
                        @error('name')
                            <span class="text-xs text-red-500 font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-1.5">
                        <label for="email" class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required placeholder="Contoh: andi@persuratan.go.id" class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-3 px-4 text-sm text-gray-700 transition">
                        @error('email')
                            <span class="text-xs text-red-500 font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-1.5">
                        <label for="password" class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Password Baru (Opsional)</label>
                        <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak ingin mengubah password" class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-3 px-4 text-sm text-gray-700 transition">
                        @error('password')
                            <span class="text-xs text-red-500 font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password baru" class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-3 px-4 text-sm text-gray-700 transition">
                    </div>

                    <!-- Role -->
                    <div class="space-y-1.5 md:col-span-2">
                        <label for="role" class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Role Akses</label>
                        <select name="role" id="role" required class="w-full bg-slate-50 border border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-3 px-4 text-sm text-gray-700 transition cursor-pointer">
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Staff Pengaju)</option>
                            <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Superadmin (Pimpinan)</option>
                        </select>
                        @error('role')
                            <span class="text-xs text-red-500 font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50">
                    <a href="{{ route('pengguna.index') }}" class="border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-bold py-3 px-8 rounded-xl text-sm transition duration-150 shadow-sm text-center">
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
