<x-app-layout>
    @section('title', 'Kelola Pengguna')

    <div class="space-y-6" x-data="{ deleteModalOpen: false, deleteActionUrl: '', deleteUserName: '' }">
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


        <!-- Title Section -->
        <div class="flex items-center justify-between">
            <h3 class="text-2xl font-bold text-gray-800 tracking-tight">Daftar Pengguna</h3>
        </div>

        <!-- Search & Action Row -->
        <form method="GET" action="{{ route('pengguna.index') }}" class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 flex-1">
                <!-- Search box -->
                <div class="relative flex-1 max-w-xs md:max-w-md">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="w-full bg-slate-50 border border-gray-150 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-2.5 pl-11 pr-4 text-sm text-gray-700 transition">
                </div>

                <!-- Role Filter select -->
                <div class="w-32 md:w-40">
                    <select name="role" onchange="this.form.submit()" class="w-full bg-slate-50 border border-gray-150 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-2.5 px-4 text-sm text-gray-700 transition cursor-pointer">
                        <option value="">Semua Role</option>
                        <option value="superadmin" {{ request('role') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
            </div>

            <!-- Tambah Pengguna Button -->
            <a href="{{ route('pengguna.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-xl text-sm transition duration-150 shadow-md shadow-blue-100 shrink-0 whitespace-nowrap">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Tambah Pengguna
            </a>
        </form>

        <!-- User Table Card -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition duration-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-gray-50 text-gray-400 text-xs font-bold uppercase tracking-wider">
                            <th class="py-4.5 px-6 w-16 text-center">No</th>
                            <th class="py-4.5 px-6">Nama Lengkap</th>
                            <th class="py-4.5 px-6">Email Address</th>
                            <th class="py-4.5 px-6">Role</th>
                            <th class="py-4.5 px-6 text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @if($pengguna->isNotEmpty())
                            @foreach($pengguna as $index => $user)
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="py-4 px-6 text-center text-sm font-semibold text-gray-500">
                                        {{ str_pad(($pengguna->currentPage() - 1) * $pengguna->perPage() + $index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="py-4 px-6 text-sm">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-gray-900">{{ $user->name }}</span>
                                            @if($user->id === Auth::id())
                                                <span class="px-2 py-0.5 text-[9px] font-black bg-black text-white rounded tracking-wide uppercase">Anda</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-500 font-medium">
                                        {{ $user->email }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="inline-block text-[10px] font-extrabold px-2.5 py-1 bg-gray-50 border border-gray-200 text-gray-700 rounded uppercase tracking-wider">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Edit -->
                                            @if($user->id === Auth::id())
                                                <a href="{{ route('profile.edit') }}" class="p-1.5 text-gray-400 hover:bg-gray-50 border border-gray-150 rounded-lg transition" title="Edit Profil Anda">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                    </svg>
                                                </a>
                                            @else
                                                <a href="{{ route('pengguna.edit', $user->id) }}" class="p-1.5 text-gray-500 hover:bg-gray-50 border border-gray-200 rounded-lg transition" title="Edit Pengguna">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                    </svg>
                                                </a>
                                            @endif

                                            <!-- Delete -->
                                            @if($user->id === Auth::id())
                                                <button type="button" disabled class="p-1.5 text-gray-300 border border-gray-100 rounded-lg cursor-not-allowed opacity-60" title="Tidak dapat menghapus akun sendiri">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            @else
                                                <button type="button" @click.prevent="deleteModalOpen = true; deleteActionUrl = '{{ route('pengguna.destroy', $user->id) }}'; deleteUserName = '{{ $user->name }}';" class="p-1.5 text-red-600 hover:bg-red-50 border border-red-100 rounded-lg transition" title="Hapus Pengguna">
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
                            <tr>
                                <td colspan="5" class="py-8 px-6 text-center text-sm font-semibold text-gray-400">
                                    Tidak ada data pengguna ditemukan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Table Footer Pagination -->
            <div class="px-6 py-4 bg-slate-50/30 border-t border-gray-50 flex items-center justify-between flex-wrap gap-4">
                <span class="text-xs font-semibold text-gray-400">
                    Menampilkan {{ $pengguna->firstItem() ?? 0 }} sampai {{ $pengguna->lastItem() ?? 0 }} dari {{ $pengguna->total() }} pengguna
                </span>
                <div class="flex items-center gap-1.5">
                    {{ $pengguna->links() }}
                </div>
            </div>
        </div>

        <!-- Custom Delete Confirmation Modal -->
        <div x-show="deleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-slate-900/30 backdrop-blur-sm transition-opacity" @click="deleteModalOpen = false"></div>
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div x-show="deleteModalOpen" x-transition class="relative transform overflow-hidden rounded-2xl bg-white p-8 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100 flex flex-col items-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-50 text-red-500 mb-6">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="text-center space-y-4 w-full">
                        <h3 class="text-2xl font-black text-gray-900 uppercase tracking-wide">Hapus Pengguna?</h3>
                        <div class="h-0.5 bg-gray-100 w-full my-4"></div>
                        <p class="text-sm text-gray-500 leading-relaxed font-medium">
                            Apakah Anda yakin ingin menghapus pengguna <span class="font-bold text-gray-900" x-text="deleteUserName"></span>? Seluruh data akses dan riwayat aktivitas terkait pengguna ini akan diarsipkan secara permanen.
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
