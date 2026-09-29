<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Manajemen Master Data Siswa</h1>
            <p class="text-sm text-slate-500">Kelola identitas peserta didik, NISN, kelas, dan jenis kelamin SD Negeri Jarak 2.</p>
        </div>
        <button wire:click="create" type="button" class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Siswa Baru
        </button>
    </div>

    @if (session()->has('message'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 text-sm font-medium flex items-center justify-between">
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- Search & Filter Card -->
    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-xs">
        <div class="relative">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama, NISN, atau kelas siswa..." class="w-full rounded-lg border border-slate-300 pl-10 pr-4 py-2 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <svg class="absolute left-3 top-2.5 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">NISN</th>
                        <th class="px-6 py-4">Nama Siswa</th>
                        <th class="px-6 py-4">Kelas</th>
                        <th class="px-6 py-4">Jenis Kelamin</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($siswas as $index => $s)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-500">{{ $siswas->firstItem() + $index }}</td>
                            <td class="px-6 py-4 font-mono font-medium text-slate-900">{{ $s->nisn }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $s->nama }}</td>
                            <td class="px-6 py-4 font-medium">
                                <span class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-800">{{ $s->kelas }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($s->jenis_kelamin === 'L')
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600">Laki-laki</span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-pink-600">Perempuan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button wire:click="edit({{ $s->id }})" class="font-medium text-indigo-600 hover:text-indigo-900 cursor-pointer">Edit</button>
                                <button wire:click="delete({{ $s->id }})" onclick="confirm('Yakin ingin menghapus data siswa ini?') || event.stopImmediatePropagation()" class="font-medium text-rose-600 hover:text-rose-900 cursor-pointer">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">Tidak ada data siswa ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $siswas->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 p-4 backdrop-blur-xs">
            <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl space-y-4 border border-slate-200">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-lg font-bold text-slate-900">{{ $siswaId ? 'Edit Data Siswa' : 'Tambah Siswa Baru' }}</h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">NISN (Nomor Induk Siswa Nasional)</label>
                        <input type="text" wire:model="nisn" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: 0012345678">
                        @error('nisn') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Lengkap Siswa</label>
                        <input type="text" wire:model="nama" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: Budi Santoso">
                        @error('nama') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kelas</label>
                            <input type="text" wire:model="kelas" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="VI-A">
                            @error('kelas') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Jenis Kelamin</label>
                            <select wire:model="jenis_kelamin" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            @error('jenis_kelamin') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                        </div>
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
