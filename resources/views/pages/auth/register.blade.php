<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Registrasi Akun Baru - SD Negeri Jarak 2</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-slate-50 flex flex-col justify-center items-center p-4">
    <div class="w-full max-w-md space-y-6">
        <!-- Logo & School Branding -->
        <div class="text-center space-y-2">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-600 text-white font-black text-2xl shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-all">
                    S
                </div>
            </a>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">SD NEGERI JARAK 2</h1>
            <p class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">Sistem Pendukung Keputusan SAW</p>
        </div>

        <!-- Register Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-xl space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-xl font-bold text-slate-900">Pendaftaran Akun Baru</h2>
                <p class="text-xs text-slate-500 mt-1">Buat akun untuk staf pengajar atau pengelola sistem.</p>
            </div>

            <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-medium" placeholder="Nama Pengguna">
                    @error('name') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase mb-1">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-medium" placeholder="email@sdnjarak2.sch.id">
                    @error('email') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase mb-1">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="new-password" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-medium" placeholder="••••••••">
                    @error('password') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase mb-1">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-medium" placeholder="••••••••">
                </div>

                <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-600/25 hover:from-indigo-500 hover:to-purple-500 transition-all cursor-pointer">
                    Daftar Akun Baru
                </button>
            </form>

            <div class="text-center text-xs text-slate-500">
                Sudah memiliki akun? <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-800">Masuk di sini</a>
            </div>
        </div>

        <div class="text-center text-xs text-slate-500">
            &copy; 2026 SD Negeri Jarak 2 Jombang. Sistem Pendukung Keputusan SAW.
        </div>
    </div>
</body>
</html>
