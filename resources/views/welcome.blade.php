<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPK Prediksi Kinerja Siswa - SD Negeri Jarak 2</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 flex flex-col justify-between selection:bg-indigo-600 selection:text-white font-sans antialiased">
    <!-- Navbar Header -->
    <header class="w-full border-b border-slate-200 bg-white/90 backdrop-blur-md sticky top-0 z-50 shadow-xs">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 text-white font-black text-xl shadow-md shadow-indigo-500/20">
                    S
                </div>
                <div>
                    <h2 class="font-bold text-base text-slate-900 leading-tight">SD Negeri Jarak 2</h2>
                    <p class="text-xs text-slate-500">SPK Prediksi Kinerja Siswa</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-500 transition-all">
                        Buka Dashboard
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-500 transition-all">
                        Masuk ke Sistem (Login)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Hero Section -->
    <main class="max-w-7xl mx-auto px-6 py-12 flex-1 flex flex-col justify-center items-center text-center space-y-10">
        <div class="space-y-6 max-w-3xl">
            <span class="inline-flex items-center gap-2 rounded-full border border-indigo-200 bg-indigo-50 px-4 py-1.5 text-xs font-semibold text-indigo-700 shadow-xs">
                <span class="h-2 w-2 rounded-full bg-indigo-600 animate-pulse"></span>
                Sistem Pendukung Keputusan Berbasis Web (Metode SAW)
            </span>

            <h1 class="text-4xl sm:text-6xl font-black text-slate-900 tracking-tight leading-tight">
                Prediksi Kinerja Siswa Metode <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-800 bg-clip-text text-transparent">SAW</span>
            </h1>

            <p class="text-slate-600 text-base sm:text-lg leading-relaxed">
                Sistem informasi interaktif untuk memetakan ketercapaian prestasi, kedisiplinan, dan keaktifan peserta didik SD Negeri Jarak 2 TP 2025/2026 secara objektif, efisien, dan transparan.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-3.5 text-base font-bold text-white shadow-lg shadow-indigo-600/25 hover:from-indigo-500 hover:to-purple-500 transition-all">
                    Masuk Sekarang & Buka Sistem
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>

        <!-- System Demo Credentials Card -->
        <div class="w-full max-w-4xl rounded-2xl border border-slate-200 bg-white p-6 text-left shadow-lg">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 0121 9z"/></svg>
                Akun Demo Login Penguji
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs font-mono">
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 space-y-1">
                    <p class="font-bold text-indigo-700">Wali Kelas</p>
                    <p class="text-slate-700">Email: walikelas@sdnjarak2.sch.id</p>
                    <p class="text-slate-500">Password: password</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 space-y-1">
                    <p class="font-bold text-purple-700">Admin Utama</p>
                    <p class="text-slate-700">Email: admin@sdnjarak2.sch.id</p>
                    <p class="text-slate-500">Password: password</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 space-y-1">
                    <p class="font-bold text-emerald-700">Kepala Sekolah</p>
                    <p class="text-slate-700">Email: kepsek@sdnjarak2.sch.id</p>
                    <p class="text-slate-500">Password: password</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-slate-200 py-6 text-center text-xs text-slate-500 bg-white">
        &copy; 2026 SD Negeri Jarak 2 Jombang. Sistem Pendukung Keputusan SAW.
    </footer>
</body>
</html>
