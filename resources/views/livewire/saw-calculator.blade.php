<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Kalkulasi & Perankingan SAW</h1>
            <p class="text-sm text-slate-500">Proses perhitungan otomatis Simple Additive Weighting dan prediksi kinerja siswa kelas {{ $kelas }}.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('laporan.pdf', ['kelas' => $kelas, 'tahun_ajaran' => $tahunAjaran, 'semester' => $semester]) }}" target="_blank" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-all shadow-xs">
                <i class="fa-solid fa-file-pdf text-rose-600"></i>
                Cetak Laporan PDF
            </a>
            <button wire:click="simpanHasil" type="button" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 transition-all cursor-pointer">
                <i class="fa-solid fa-floppy-disk"></i>
                Simpan Hasil Ranking
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 text-sm font-medium">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-rose-800 text-sm font-medium">
            {{ session('error') }}
        </div>
    @endif

    <!-- Toolbar Filter -->
    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-xs grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div>
            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kelas</label>
            <select wire:model.live="kelas" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="VI-A">Kelas VI-A</option>
                <option value="VI-B">Kelas VI-B</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Tahun Ajaran</label>
            <select wire:model.live="tahunAjaran" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="2025/2026">2025/2026</option>
                <option value="2024/2025">2024/2025</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Semester</label>
            <select wire:model.live="semester" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="genap">Genap</option>
                <option value="ganjil">Ganjil</option>
            </select>
        </div>
    </div>

    @if(empty($matriksX))
        <div class="rounded-xl border border-dashed border-slate-300 bg-white p-12 text-center">
            <i class="fa-solid fa-folder-open text-4xl text-slate-300 mb-2 block"></i>
            <h3 class="mt-2 text-sm font-semibold text-slate-900">Belum Ada Data Penilaian</h3>
            <p class="mt-1 text-sm text-slate-500">Silakan input penilaian kriteria terlebih dahulu untuk kelas {{ $kelas }} TP {{ $tahunAjaran }} {{ $semester }}.</p>
            <div class="mt-6">
                <a href="{{ route('penilaian.input') }}" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    <i class="fa-solid fa-pen-to-square"></i> Input Nilai Sekarang
                </a>
            </div>
        </div>
    @else
        <!-- Tab Navigation Buttons -->
        <div class="border-b border-slate-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button wire:click="$set('activeTab', 'tabV')" class="{{ $activeTab === 'tabV' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }} flex items-center gap-2 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-bold transition-all cursor-pointer">
                    <i class="fa-solid fa-trophy text-amber-500"></i>
                    <span>Hasil Preferensi (Vi) & Peringkat</span>
                </button>

                <button wire:click="$set('activeTab', 'tabR')" class="{{ $activeTab === 'tabR' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }} flex items-center gap-2 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-bold transition-all cursor-pointer">
                    <i class="fa-solid fa-chart-simple text-blue-500"></i>
                    <span>Matriks Normalisasi (R)</span>
                </button>

                <button wire:click="$set('activeTab', 'tabX')" class="{{ $activeTab === 'tabX' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }} flex items-center gap-2 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-bold transition-all cursor-pointer">
                    <i class="fa-solid fa-table-list text-purple-500"></i>
                    <span>Matriks Keputusan (X)</span>
                </button>
            </nav>
        </div>

        <!-- TAB CONTENT V (Hasil Ranking) -->
        @if($activeTab === 'tabV')
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xs space-y-4">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Tabel Hasil Ranking & Prediksi Kinerja Siswa</h2>
                        <p class="text-xs text-slate-500">Perhitungan preferensi Vi dengan perangkingan tertinggi ke terendah.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4">Peringkat</th>
                                <th class="px-6 py-4">NISN</th>
                                <th class="px-6 py-4">Nama Siswa</th>
                                <th class="px-6 py-4 text-center">Nilai Preferensi (Vi)</th>
                                <th class="px-6 py-4 text-center">Prediksi Kinerja</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($hasilV as $h)
                                <tr class="hover:bg-slate-50 transition-colors {{ $h['rank'] === 1 ? 'bg-amber-50/50' : '' }}">
                                    <td class="px-6 py-4 font-bold text-slate-900 flex items-center gap-2">
                                        @if($h['rank'] === 1)
                                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-amber-100 text-amber-800 font-black text-xs shadow-xs gap-1">
                                                <i class="fa-solid fa-trophy text-amber-500"></i> 1
                                            </span>
                                        @elseif($h['rank'] === 2)
                                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-slate-200 text-slate-700 font-black text-xs shadow-xs gap-1">
                                                <i class="fa-solid fa-medal text-slate-500"></i> 2
                                            </span>
                                        @elseif($h['rank'] === 3)
                                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-amber-100 text-amber-900 font-black text-xs shadow-xs gap-1">
                                                <i class="fa-solid fa-award text-amber-700"></i> 3
                                            </span>
                                        @else
                                            <span class="flex h-7 w-7 items-center justify-center font-bold text-slate-500 text-xs">{{ $h['rank'] }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-mono text-xs">{{ $h['siswa']->nisn }}</td>
                                    <td class="px-6 py-4 font-bold text-slate-900">{{ $h['siswa']->nama }}</td>
                                    <td class="px-6 py-4 text-center font-mono font-bold text-indigo-600 text-base">{{ number_format($h['nilai_v'], 4) }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($h['predikat'] === 'Sangat Baik')
                                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">Sangat Baik</span>
                                        @elseif($h['predikat'] === 'Baik')
                                            <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800">Baik</span>
                                        @elseif($h['predikat'] === 'Cukup')
                                            <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">Cukup</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-800">Perlu Pembinaan</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- TAB CONTENT R (Normalisasi) -->
        @if($activeTab === 'tabR')
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xs">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-900">Matriks Normalisasi (R)</h2>
                    <p class="text-xs text-slate-500">Benefit: r_ij = x_ij/max(x_ij), Cost: r_ij = min(x_ij)/x_ij.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4">Nama Siswa</th>
                                @foreach($kriterias as $k)
                                    <th class="px-6 py-4 text-center">{{ $k->kode }} (r_ij)</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($penilaians as $p)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $p->siswa->nama }}</td>
                                    @foreach($kriterias as $k)
                                        <td class="px-6 py-4 text-center font-mono font-medium text-slate-800">
                                            {{ number_format($matriksR[$p->id][$k->id] ?? 0, 4) }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- TAB CONTENT X (Matriks Keputusan) -->
        @if($activeTab === 'tabX')
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xs">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-900">Matriks Keputusan (X)</h2>
                    <p class="text-xs text-slate-500">Nilai mentah kriteria C1, C2, C3, C4 peserta didik.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4">Nama Siswa</th>
                                @foreach($kriterias as $k)
                                    <th class="px-6 py-4 text-center">{{ $k->kode }} ({{ $k->jenis }})</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($penilaians as $p)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $p->siswa->nama }}</td>
                                    @foreach($kriterias as $k)
                                        <td class="px-6 py-4 text-center font-mono font-medium">
                                            {{ $matriksX[$p->id][$k->id] ?? '-' }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @endif
</div>
