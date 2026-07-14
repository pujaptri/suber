<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-[#F8FAFC]">
        <div class="flex min-h-screen" x-data="{ sidebarOpen: false }">
            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-100 flex flex-col justify-between shrink-0 z-40 transition-transform duration-300 md:relative md:translate-x-0 h-screen sticky top-0">
                <!-- Top section: Logo & Nav -->
                <div>
                    <!-- Brand logo area -->
                    <div class="p-6 border-b border-gray-50 flex items-center gap-3">
                        <x-application-logo class="w-10 h-10 shrink-0" />
                        <div>
                            <h1 class="text-lg font-bold text-gray-900 leading-none tracking-wide">SUBER</h1>
                            <span class="text-[9px] font-bold text-gray-400 tracking-wider uppercase block mt-1">SISTEM INFORMASI SURAT</span>
                        </div>
                    </div>

                    <!-- Navigation menu -->
                    <nav class="p-4 space-y-1.5">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 transition duration-150 group {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white font-bold rounded-xl shadow-md shadow-blue-100' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50/60 rounded-xl' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="text-sm">Dashboard</span>
                        </a>
 
                        <!-- Surat Masuk -->
                        <a href="{{ route('surat-masuk.index') }}" class="flex items-center gap-3 px-4 py-3 transition duration-150 group {{ request()->routeIs('surat-masuk.*') ? 'bg-blue-600 text-white font-bold rounded-xl shadow-md shadow-blue-100' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50/60 rounded-xl' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('surat-masuk.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20"></path>
                            </svg>
                            <span class="text-sm">Surat Masuk</span>
                        </a>
 
                        <!-- Surat Keluar -->
                        <a href="{{ route('surat-keluar.index') }}" class="flex items-center gap-3 px-4 py-3 transition duration-150 group {{ request()->routeIs('surat-keluar.*') ? 'bg-blue-600 text-white font-bold rounded-xl shadow-md shadow-blue-100' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50/60 rounded-xl' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('surat-keluar.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            <span class="text-sm">Surat Keluar</span>
                        </a>
 
                        <!-- Kategori -->
                        <a href="{{ route('kategori.index') }}" class="flex items-center gap-3 px-4 py-3 transition duration-150 group {{ request()->routeIs('kategori.*') ? 'bg-blue-600 text-white font-bold rounded-xl shadow-md shadow-blue-100' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50/60 rounded-xl' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('kategori.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span class="text-sm">Kategori</span>
                        </a>
 
                        <!-- Kelola Pengguna -->
                        @if(Auth::user()->isSuperAdmin())
                        <a href="{{ route('pengguna.index') }}" class="flex items-center gap-3 px-4 py-3 transition duration-150 group {{ request()->routeIs('pengguna.*') ? 'bg-blue-600 text-white font-bold rounded-xl shadow-md shadow-blue-100' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50/60 rounded-xl' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('pengguna.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="text-sm">Kelola Pengguna</span>
                        </a>

                        <!-- Log Aktivitas -->
                        <a href="{{ route('log-aktivitas.index') }}" class="flex items-center gap-3 px-4 py-3 transition duration-150 group {{ request()->routeIs('log-aktivitas.*') ? 'bg-blue-600 text-white font-bold rounded-xl shadow-md shadow-blue-100' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50/60 rounded-xl' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('log-aktivitas.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm">Log Aktivitas</span>
                        </a>
                        @endif
                    </nav>
                </div>

                <!-- Bottom section: Profil -->
                <div class="p-4 border-t border-gray-50 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 transition duration-150 group {{ request()->routeIs('profile.edit') ? 'bg-blue-600 text-white font-bold rounded-xl shadow-md shadow-blue-100' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50/60 rounded-xl' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('profile.edit') ? 'text-white' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm">Profil</span>
                    </a>
                </div>
            </aside>

            <!-- Backdrop for mobile sidebar -->
            <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-gray-900/20 backdrop-blur-sm z-30 md:hidden transition-opacity" x-transition></div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 min-h-screen">
                <!-- Topbar -->
                <header class="bg-white border-b border-gray-100 h-20 px-8 flex items-center justify-between sticky top-0 z-20">
                    <div class="flex items-center gap-4">
                        <!-- Mobile Hamburger Button -->
                        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700 md:hidden focus:outline-none p-1 rounded-lg hover:bg-gray-50 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        <!-- Dynamic Page Title -->
                        <h2 class="text-xl md:text-2xl font-bold text-gray-800 tracking-tight leading-none">@yield('title', 'Dashboard')</h2>
                    </div>

                    <!-- Right Elements -->
                    <div class="flex items-center gap-5">


                        <!-- User Menu Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-3 focus:outline-none group">
                                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm uppercase shrink-0 transition group-hover:bg-blue-100">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="hidden md:flex flex-col text-left">
                                    <span class="text-sm font-bold text-gray-800 leading-tight group-hover:text-gray-900 transition">{{ Auth::user()->name }}</span>
                                    <span class="text-[11px] font-medium text-gray-400 capitalize mt-0.5">
                                        @if(Auth::user()->role === 'superadmin')
                                            Administrator
                                        @else
                                            {{ ucfirst(Auth::user()->role) }}
                                        @endif
                                    </span>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" x-cloak @click.away="open = false" x-transition class="absolute right-0 mt-2.5 w-48 bg-white border border-gray-100 rounded-xl shadow-lg py-1 z-40">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    {{ __('Profile') }}
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
