<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Input Penilaian Kriteria Siswa</h1>
            <p class="text-sm text-slate-500">Pengisian angka kriteria C1, C2, C3, C4 untuk masing-masing peserta didik.</p>
        </div>
        <button wire:click="saveAll" type="button" class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-all cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan Semua Penilaian
        </button>
    </div>

    @if (session()->has('message'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 text-sm font-medium">
            {{ session('message') }}
        </div>
    @endif

    <!-- Filter Toolbar -->
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

    <!-- Matrix Input Table -->
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">NISN</th>
                        <th class="px-6 py-4">Nama Siswa</th>
                        @foreach($kriterias as $k)
                            <th class="px-4 py-4 text-center">
                                <div>{{ $k->kode }}</div>
                                <div class="text-[10px] normal-case text-slate-400 font-normal">({{ $k->nama_kriteria }})</div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($siswas as $index => $s)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-slate-500 font-medium">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-mono text-xs font-medium">{{ $s->nisn }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $s->nama }}</td>
                            @foreach($kriterias as $k)
                                <td class="px-3 py-3 text-center min-w-[100px]">
                                    <input type="number" step="0.01" wire:model="nilaiInput.{{ $s->id }}.{{ $k->id }}" class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-center text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-mono" placeholder="0">
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 3 + count($kriterias) }}" class="px-6 py-8 text-center text-slate-500">Belum ada siswa di kelas {{ $kelas }}.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
