<x-app-layout>
    @section('title', 'Log Aktivitas')

    <div class="space-y-6">
        <!-- Title and Quick Action Buttons -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1">
                <h3 class="text-2xl font-bold text-gray-800 tracking-tight">Riwayat Aktivitas</h3>
            </div>
            
            <div class="flex items-center gap-3 shrink-0">
                <!-- Period Quick Filters -->
                <div class="inline-flex rounded-xl p-1 bg-slate-100 border border-slate-200">
                    <a href="{{ route('log-aktivitas.index', array_merge(request()->except('page'), ['filter_period' => 'harian'])) }}" 
                       class="px-4 py-1.5 rounded-lg text-xs font-bold uppercase transition duration-150 {{ request('filter_period') === 'harian' ? 'bg-white text-gray-900 shadow-sm border border-slate-200/50' : 'text-gray-500 hover:text-gray-800' }}">
                        Harian
                    </a>
                    <a href="{{ route('log-aktivitas.index', array_merge(request()->except('page'), ['filter_period' => 'mingguan'])) }}" 
                       class="px-4 py-1.5 rounded-lg text-xs font-bold uppercase transition duration-150 {{ request('filter_period') === 'mingguan' ? 'bg-white text-gray-900 shadow-sm border border-slate-200/50' : 'text-gray-500 hover:text-gray-800' }}">
                        Mingguan
                    </a>
                    <a href="{{ route('log-aktivitas.index', array_merge(request()->except('page'), ['filter_period' => 'bulanan'])) }}" 
                       class="px-4 py-1.5 rounded-lg text-xs font-bold uppercase transition duration-150 {{ request('filter_period') === 'bulanan' ? 'bg-white text-gray-900 shadow-sm border border-slate-200/50' : 'text-gray-500 hover:text-gray-800' }}">
                        Bulanan
                    </a>
                    @if(request()->filled('filter_period'))
                        <a href="{{ route('log-aktivitas.index', request()->except(['filter_period', 'page'])) }}" 
                           class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase text-red-500 hover:text-red-700 transition">
                            ✕ Reset
                        </a>
                    @endif
                </div>

                <!-- Ekspor Log Button -->
                <a href="{{ route('log-aktivitas.ekspor', request()->query()) }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-xl text-sm transition duration-150 shadow-md shadow-blue-100 whitespace-nowrap">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Ekspor Log
                </a>
            </div>
        </div>

        <!-- Filter Card -->
        <form method="GET" action="{{ route('log-aktivitas.index') }}" class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-200">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 block">Filter Data</span>
            
            @if(request()->filled('filter_period'))
                <input type="hidden" name="filter_period" value="{{ request('filter_period') }}">
            @endif

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <!-- Search input -->
                <div class="md:col-span-1">
                    <label for="search" class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5 block">Cari</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari aktivitas..." class="w-full bg-slate-50 border border-gray-150 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-2.5 pl-11 pr-4 text-sm text-gray-700 transition">
                    </div>
                </div>

                <!-- Rentang Tanggal -->
                <div class="md:col-span-1 grid grid-cols-2 gap-2">
                    <div>
                        <label for="tanggal_dari" class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5 block">Dari</label>
                        <input type="date" name="tanggal_dari" id="tanggal_dari" value="{{ request('tanggal_dari') }}" {{ request()->filled('filter_period') ? 'disabled' : '' }} class="w-full bg-slate-50 border border-gray-150 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-2.5 px-3.5 text-sm text-gray-700 transition disabled:opacity-50">
                    </div>
                    <div>
                        <label for="tanggal_sampai" class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5 block">Sampai</label>
                        <input type="date" name="tanggal_sampai" id="tanggal_sampai" value="{{ request('tanggal_sampai') }}" {{ request()->filled('filter_period') ? 'disabled' : '' }} class="w-full bg-slate-50 border border-gray-150 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-2.5 px-3.5 text-sm text-gray-700 transition disabled:opacity-50">
                    </div>
                </div>

                <!-- User Filter -->
                <div class="md:col-span-1">
                    <label for="user_id" class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5 block">User</label>
                    <select name="user_id" id="user_id" class="w-full bg-slate-50 border border-gray-150 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-2.5 px-4 text-sm text-gray-700 transition cursor-pointer">
                        <option value="">Semua User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Type Filter -->
                <div class="md:col-span-1">
                    <label for="jenis_aksi" class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5 block">Aksi</label>
                    <select name="jenis_aksi" id="jenis_aksi" class="w-full bg-slate-50 border border-gray-150 focus:border-blue-500 focus:bg-white focus:ring-0 rounded-xl py-2.5 px-4 text-sm text-gray-700 transition cursor-pointer">
                        <option value="">Semua Aksi</option>
                        <option value="tambah" {{ request('jenis_aksi') == 'tambah' ? 'selected' : '' }}>Tambah/Upload</option>
                        <option value="edit" {{ request('jenis_aksi') == 'edit' ? 'selected' : '' }}>Edit/Update</option>
                        <option value="hapus" {{ request('jenis_aksi') == 'hapus' ? 'selected' : '' }}>Hapus/Tolak</option>
                        <option value="login" {{ request('jenis_aksi') == 'login' ? 'selected' : '' }}>Login</option>
                        <option value="logout" {{ request('jenis_aksi') == 'logout' ? 'selected' : '' }}>Logout</option>
                        <option value="approve" {{ request('jenis_aksi') == 'approve' ? 'selected' : '' }}>Approve</option>
                        <option value="distribusi" {{ request('jenis_aksi') == 'distribusi' ? 'selected' : '' }}>Distribusi</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="md:col-span-1 flex gap-2">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-xl text-sm transition duration-150 shadow-sm text-center whitespace-nowrap">
                        Filter
                    </button>
                    @if(request()->anyFilled(['search', 'tanggal_dari', 'tanggal_sampai', 'user_id', 'jenis_aksi']))
                        <a href="{{ route('log-aktivitas.index') }}" class="flex-1 border border-gray-200 text-gray-650 hover:bg-gray-50 font-semibold py-2.5 px-4 rounded-xl text-sm transition duration-150 shadow-sm text-center">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <!-- Table Card -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition duration-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-gray-50 text-gray-400 text-xs font-bold uppercase tracking-wider">
                            <th class="py-4.5 px-6">Waktu / Tanggal</th>
                            <th class="py-4.5 px-6">ID Aktivitas</th>
                            <th class="py-4.5 px-6">User</th>
                            <th class="py-4.5 px-6">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @if($logs->isNotEmpty())
                            @foreach($logs as $log)
                                @php
                                    // User Avatar initials
                                    $words = explode(' ', $log->user->name ?? 'U');
                                    $initials = '';
                                    if (count($words) >= 2) {
                                        $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                                    } else {
                                        $initials = strtoupper(substr($log->user->name ?? 'U', 0, 2));
                                    }
                                @endphp
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="py-4.5 px-6 whitespace-nowrap">
                                        <span class="text-sm font-bold text-gray-900 block">
                                            {{ $log->waktu_aktivitas->locale('id')->isoFormat('D MMMM Y') }}
                                        </span>
                                        <span class="text-xs text-gray-400 font-semibold block mt-0.5">
                                            {{ $log->waktu_aktivitas->format('H:i:s') }}
                                        </span>
                                    </td>
                                    <td class="py-4.5 px-6 whitespace-nowrap">
                                        <span class="inline-block text-[11px] font-bold px-2.5 py-1 bg-gray-100 text-gray-700 rounded border border-gray-200 uppercase tracking-wide">
                                            LOG-{{ str_pad($log->id, 6, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td class="py-4.5 px-6 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-slate-100 border border-gray-200 text-gray-600 font-bold flex items-center justify-center text-xs tracking-wider uppercase">
                                                {{ $initials }}
                                            </div>
                                            <span class="text-sm font-bold text-gray-800">{{ $log->user->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4.5 px-6 text-sm text-gray-650 font-medium leading-relaxed">
                                        <span>{{ $log->deskripsi }}</span>
                                        @if($log->ip_address)
                                            <span class="block text-[10px] text-gray-400 font-semibold mt-1 uppercase tracking-wider">
                                                IP: {{ $log->ip_address }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="py-12 px-6 text-center text-sm font-semibold text-gray-400">
                                    Tidak ada data riwayat aktivitas ditemukan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Table Footer Pagination -->
            <div class="px-6 py-4 bg-slate-50/30 border-t border-gray-50 flex items-center justify-between flex-wrap gap-4">
                <span class="text-xs font-semibold text-gray-400">
                    Menampilkan {{ $logs->firstItem() ?? 0 }} sampai {{ $logs->lastItem() ?? 0 }} dari {{ $logs->total() }} data
                </span>
                <div class="flex items-center gap-1.5">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="w-full text-center text-xs font-semibold text-gray-400 pt-6 border-t border-gray-100 block mx-auto">
            © 2026 SUBER - Sistem Informasi Surat
        </footer>
    </div>
</x-app-layout>
