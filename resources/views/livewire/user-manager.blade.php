<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Manajemen Pengguna & Role Access</h1>
            <p class="text-sm text-slate-500">Kelola akun pengguna dan hak akses peran (Admin, Wali Kelas, Kepala Sekolah).</p>
        </div>
        <button wire:click="create" type="button" class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pengguna Baru
        </button>
    </div>

    @if (session()->has('message'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 text-sm font-medium flex items-center justify-between">
            <span>{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-rose-800 text-sm font-medium flex items-center justify-between">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">Nama Pengguna</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role / Hak Akses</th>
                        <th class="px-6 py-4">Tanggal Dibuat</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-900 flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 font-bold text-indigo-700">
                                    {{ $u->initials() }}
                                </div>
                                <span>{{ $u->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-mono text-xs">{{ $u->email }}</td>
                            <td class="px-6 py-4">
                                @foreach($u->roles as $r)
                                    @if($r->name === 'Admin')
                                        <span class="inline-flex items-center rounded-md bg-purple-50 px-2.5 py-1 text-xs font-semibold text-purple-700 ring-1 ring-inset ring-purple-700/10">Admin</span>
                                    @elseif($r->name === 'Wali Kelas')
                                        <span class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-700/10">Wali Kelas</span>
                                    @else
                                        <span class="inline-flex items-center rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-700/10">Kepala Sekolah</span>
                                    @endif
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-xs">{{ $u->created_at?->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button wire:click="edit({{ $u->id }})" class="font-medium text-indigo-600 hover:text-indigo-900 cursor-pointer">Edit</button>
                                @if($u->id !== auth()->id())
                                    <button wire:click="delete({{ $u->id }})" onclick="confirm('Yakin ingin menghapus akun ini?') || event.stopImmediatePropagation()" class="font-medium text-rose-600 hover:text-rose-900 cursor-pointer">Hapus</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">Tidak ada data akun pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 p-4 backdrop-blur-xs">
            <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl space-y-4 border border-slate-200">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-lg font-bold text-slate-900">{{ $userId ? 'Edit Akun Pengguna' : 'Tambah Pengguna Baru' }}</h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Pengguna</label>
                        <input type="text" wire:model="name" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Nama lengkap">
                        @error('name') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Alamat Email</label>
                        <input type="email" wire:model="email" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="email@sdnjarak2.sch.id">
                        @error('email') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Password {{ $userId ? '(Kosongkan jika tidak diubah)' : '' }}</label>
                        <input type="password" wire:model="password" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="••••••••">
                        @error('password') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Role / Peran Pengguna</label>
                        <select wire:model="role" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @foreach($roles as $r)
                                <option value="{{ $r->name }}">{{ $r->name }}</option>
                            @endforeach
                        </select>
                        @error('role') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
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
