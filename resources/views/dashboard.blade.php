<x-layouts::app :title="__('Dashboard SPK Prediksi Kinerja Siswa')">
    <div class="space-y-6">
        <!-- Welcome Hero Banner -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-800 p-8 text-white shadow-lg">
            <div class="relative z-10 space-y-2">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3.5 py-1 text-xs font-semibold text-white backdrop-blur-md">
                    <i class="fa-solid fa-chart-line text-xs"></i>
                    Sistem Pendukung Keputusan (SPK) SAW
                </span>
                <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl text-white">Selamat Datang, {{ auth()->user()->name }}!</h1>
                <p class="max-w-2xl text-indigo-100 text-sm sm:text-base">
                    Sistem Prediksi Kinerja Siswa SD Negeri Jarak 2 berbasis Metode Simple Additive Weighting (SAW) TP 2025/2026.
                </p>
            </div>
            <div class="absolute -bottom-10 -right-10 h-64 w-64 rounded-full bg-white/10 blur-2xl"></div>
        </div>

        @php
            $totalSiswa = \App\Models\Siswa::count();
            $totalKriteria = \App\Models\Kriteria::count();
            $rankingSatu = \App\Models\Penilaian::with('siswa')->where('rank', 1)->orderBy('updated_at', 'desc')->first();
            $totalPenilaian = \App\Models\Penilaian::count();
        @endphp

        <!-- Metrics Grid Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Siswa -->
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-xs flex items-center justify-between hover:border-slate-300 transition-all">
                <div class="space-y-1">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Siswa</p>
                    <p class="text-3xl font-black text-slate-800">{{ $totalSiswa }}</p>
                    <p class="text-xs text-slate-500 font-medium">Peserta Didik Terdaftar</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <i class="fa-solid fa-user-graduate text-xl"></i>
                </div>
            </div>

            <!-- Total Kriteria -->
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-xs flex items-center justify-between hover:border-slate-300 transition-all">
                <div class="space-y-1">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kriteria Penilaian</p>
                    <p class="text-3xl font-black text-slate-800">{{ $totalKriteria }}</p>
                    <p class="text-xs text-slate-500 font-medium">Variabel Penilaian SAW</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                    <i class="fa-solid fa-sliders text-xl"></i>
                </div>
            </div>

            <!-- Ranking 1 Highlight -->
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-xs flex items-center justify-between hover:border-slate-300 transition-all">
                <div class="space-y-1">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Prediksi Terbaik (Rank 1)</p>
                    <p class="text-lg font-extrabold text-emerald-600 truncate max-w-[150px]">{{ $rankingSatu?->siswa?->nama ?? '-' }}</p>
                    <p class="text-xs text-slate-500 font-medium">Nilai V: {{ $rankingSatu?->nilai_v ? number_format($rankingSatu->nilai_v, 4) : '-' }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-500 shadow-xs">
                    <i class="fa-solid fa-trophy text-xl"></i>
                </div>
            </div>

            <!-- Total Penilaian -->
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-xs flex items-center justify-between hover:border-slate-300 transition-all">
                <div class="space-y-1">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Penilaian</p>
                    <p class="text-3xl font-black text-slate-800">{{ $totalPenilaian }}</p>
                    <p class="text-xs text-slate-500 font-medium">Data Transaksi SPK</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="fa-solid fa-clipboard-check text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Quick Access Action Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <a href="{{ route('penilaian.input') }}" class="group rounded-xl border border-slate-200 bg-white p-6 shadow-xs hover:border-indigo-500 hover:shadow-md transition-all">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                        <i class="fa-solid fa-pen-to-square text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">Input Penilaian Siswa</h3>
                        <p class="text-xs text-slate-500">Isi data nilai kriteria C1-C4 per semester</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('saw.index') }}" class="group rounded-xl border border-slate-200 bg-white p-6 shadow-xs hover:border-emerald-500 hover:shadow-md transition-all">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                        <i class="fa-solid fa-calculator text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 group-hover:text-emerald-600 transition-colors">Kalkulasi Matriks SAW</h3>
                        <p class="text-xs text-slate-500">Lihat matriks X, R, & hasil ranking V</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('kriteria.index') }}" class="group rounded-xl border border-slate-200 bg-white p-6 shadow-xs hover:border-purple-500 hover:shadow-md transition-all">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-all">
                        <i class="fa-solid fa-sliders text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 group-hover:text-purple-600 transition-colors">Konfigurasi Kriteria</h3>
                        <p class="text-xs text-slate-500">Atur bobot kriteria (Wj) & sifat kriteria</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</x-layouts::app>
