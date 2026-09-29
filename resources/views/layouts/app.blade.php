<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ? $title . ' - ' : '' }}SPK Prediksi Kinerja Siswa SD Negeri Jarak 2</title>

    <!-- FontAwesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-slate-50">
    <div class="min-h-screen flex">
        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between shrink-0 sticky top-0 h-screen shadow-xs z-30">
            <div class="p-5 space-y-6 overflow-y-auto">
                <!-- Brand Header -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-600 text-white font-black text-xl shadow-md shadow-indigo-500/20 group-hover:scale-105 transition-all">
                        <i class="fa-solid fa-graduation-cap text-lg"></i>
                    </div>
                    <div>
                        <span class="font-extrabold text-sm text-slate-900 leading-tight block">SD NEGERI JARAK 2</span>
                        <span class="text-[11px] text-slate-500 font-medium block">SPK Kinerja Siswa</span>
                    </div>
                </a>

                <hr class="border-slate-100">

                <!-- Navigation Sections -->
                <div class="space-y-6">
                    <!-- Section: Utama -->
                    <div class="space-y-1">
                        <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">UTAMA</p>
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">
                            <i class="fa-solid fa-house text-sm w-4 text-center"></i>
                            Dashboard
                        </a>
                    </div>

                    <!-- Section: Master Data -->
                    <div class="space-y-1">
                        <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">MASTER DATA</p>
                        <a href="{{ route('kriteria.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('kriteria.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">
                            <i class="fa-solid fa-sliders text-sm w-4 text-center"></i>
                            Data Kriteria & Bobot
                        </a>
                        <a href="{{ route('siswa.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('siswa.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">
                            <i class="fa-solid fa-user-graduate text-sm w-4 text-center"></i>
                            Data Siswa
                        </a>
                        <a href="{{ route('user.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('user.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">
                            <i class="fa-solid fa-users-gear text-sm w-4 text-center"></i>
                            Pengguna & Role
                        </a>
                    </div>

                    <!-- Section: SPK SAW -->
                    <div class="space-y-1">
                        <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">SPK SAW</p>
                        <a href="{{ route('penilaian.input') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('penilaian.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">
                            <i class="fa-solid fa-pen-to-square text-sm w-4 text-center"></i>
                            Input Penilaian
                        </a>
                        <a href="{{ route('saw.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('saw.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">
                            <i class="fa-solid fa-calculator text-sm w-4 text-center"></i>
                            Kalkulasi & Ranking
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar User Profile Footer -->
            @auth
                <div class="p-4 border-t border-slate-200 bg-slate-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 font-bold text-xs shrink-0">
                                {{ auth()->user()->initials() }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-[10px] font-semibold text-indigo-600 truncate">{{ auth()->user()->roles->first()?->name ?? 'Pengguna' }}</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" title="Keluar dari sistem" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all cursor-pointer">
                                <i class="fa-solid fa-right-from-bracket text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Header Bar -->
            <header class="bg-white border-b border-slate-200 h-16 px-6 flex items-center justify-between sticky top-0 z-20 shadow-xs">
                <div>
                    <h1 class="font-extrabold text-base text-slate-900 leading-tight">{{ $title ?? 'SPK Prediksi Kinerja Siswa' }}</h1>
                    <p class="text-xs text-slate-500 font-medium">SD Negeri Jarak 2 Kabupaten Jombang</p>
                </div>

                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 border border-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                        <span class="h-2 w-2 rounded-full bg-indigo-600"></span>
                        TP 2025/2026
                    </span>
                </div>
            </header>

            <!-- Main Body Slot -->
            <main class="flex-1 p-6 lg:p-8 space-y-6">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-slate-200 py-4 px-6 text-center text-xs text-slate-500 font-medium mt-auto">
                &copy; 2026 SD Negeri Jarak 2 Jombang. Sistem Pendukung Keputusan SAW.
            </footer>
        </div>
    </div>

    @livewireScripts
</body>
</html>
