<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Manajemen Kriteria & Bobot</h1>
            <p class="text-sm text-slate-500">Kelola kriteria penilaian, bobot (Wj), dan sifat kriteria (Benefit / Cost) untuk algoritma SAW.</p>
        </div>
        <button wire:click="create" type="button" class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Kriteria
        </button>
    </div>

    @if (session()->has('message'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 text-sm font-medium flex items-center justify-between">
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- Total Weight Badge Card -->
    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-xs flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg {{ abs($totalBobot - 1.0) < 0.001 ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Akumulasi Total Bobot (Wj)</p>
                <p class="text-lg font-bold text-slate-900">{{ number_format($totalBobot * 100, 0) }}% ({{ number_format($totalBobot, 2) }})</p>
            </div>
        </div>
        <div>
            @if (abs($totalBobot - 1.0) < 0.001)
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span> Total Bobot Ideal (100%)
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-600"></span> Total Bobot Belum 100%
                </span>
            @endif
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">Kode</th>
                        <th class="px-6 py-4">Nama Kriteria</th>
                        <th class="px-6 py-4">Sifat (Type)</th>
                        <th class="px-6 py-4">Bobot (Wj)</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($kriterias as $k)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-900">{{ $k->kode }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $k->nama_kriteria }}</td>
                            <td class="px-6 py-4">
                                @if($k->jenis === 'benefit')
                                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-700/10">Benefit</span>
                                @else
                                    <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-semibold text-purple-700 ring-1 ring-inset ring-purple-700/10">Cost</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-mono font-medium">{{ number_format($k->bobot * 100, 0) }}% ({{ number_format($k->bobot, 2) }})</td>
                            <td class="px-6 py-4 text-slate-500">{{ $k->deskripsi ?? '-' }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button wire:click="edit({{ $k->id }})" class="font-medium text-indigo-600 hover:text-indigo-900 cursor-pointer">Edit</button>
                                <button wire:click="delete({{ $k->id }})" onclick="confirm('Yakin ingin menghapus kriteria ini?') || event.stopImmediatePropagation()" class="font-medium text-rose-600 hover:text-rose-900 cursor-pointer">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">Belum ada kriteria yang ditambahkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 p-4 backdrop-blur-xs">
            <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl space-y-4 border border-slate-200">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-lg font-bold text-slate-900">{{ $kriteriaId ? 'Edit Kriteria' : 'Tambah Kriteria Baru' }}</h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kode Kriteria</label>
                        <input type="text" wire:model="kode" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: C1">
                        @error('kode') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Kriteria</label>
                        <input type="text" wire:model="nama_kriteria" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: Nilai Rapor">
                        @error('nama_kriteria') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Bobot (0.01 - 1.00)</label>
                            <input type="number" step="0.01" wire:model="bobot" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="0.40">
                            @error('bobot') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Sifat (Type)</label>
                            <select wire:model="jenis" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="benefit">Benefit (Makin Besar Makin Baik)</option>
                                <option value="cost">Cost (Makin Kecil Makin Baik)</option>
                            </select>
                            @error('jenis') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Deskripsi</label>
                        <input type="text" wire:model="deskripsi" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Keterangan singkat kriteria">
                        @error('deskripsi') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" wire:click="$set('showModal', false)" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 cursor-pointer">Batal</button>
                        <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 cursor-pointer">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
