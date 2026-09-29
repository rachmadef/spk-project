<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - SPK Prediksi Kinerja Siswa SD Negeri Jarak 2</title>

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

        <!-- Login Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-xl space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-xl font-bold text-slate-900">Masuk ke Account Anda</h2>
                <p class="text-xs text-slate-500 mt-1">Masukkan email dan password untuk mengakses sistem SPK.</p>
            </div>

            @if (session('status'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-3 text-xs text-emerald-800 font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase mb-1">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-medium" placeholder="email@sdnjarak2.sch.id">
                    @error('email') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Password Input -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">Lupa password?</a>
                        @endif
                    </div>
                    <input type="password" id="password" name="password" required autocomplete="current-password" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-medium" placeholder="••••••••">
                    @error('password') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="remember" class="ml-2 block text-xs text-slate-600 font-medium">Ingat saya di perangkat ini</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-600/25 hover:from-indigo-500 hover:to-purple-500 transition-all cursor-pointer">
                    Masuk ke Sistem (Login)
                </button>
            </form>

            <!-- Quick Demo Account Auto-Fill Buttons -->
            <div class="pt-4 border-t border-slate-100 space-y-2">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 text-center">Pilih Akun Demo Quick-Fill</p>
                <div class="grid grid-cols-3 gap-2 text-xs">
                    <button type="button" onclick="fillAccount('walikelas@sdnjarak2.sch.id')" class="rounded-lg border border-slate-200 bg-slate-50 px-2 py-1.5 text-center font-bold text-indigo-700 hover:bg-indigo-50 hover:border-indigo-300 transition-all cursor-pointer">
                        Wali Kelas
                    </button>
                    <button type="button" onclick="fillAccount('admin@sdnjarak2.sch.id')" class="rounded-lg border border-slate-200 bg-slate-50 px-2 py-1.5 text-center font-bold text-purple-700 hover:bg-purple-50 hover:border-purple-300 transition-all cursor-pointer">
                        Admin
                    </button>
                    <button type="button" onclick="fillAccount('kepsek@sdnjarak2.sch.id')" class="rounded-lg border border-slate-200 bg-slate-50 px-2 py-1.5 text-center font-bold text-emerald-700 hover:bg-emerald-50 hover:border-emerald-300 transition-all cursor-pointer">
                        Kepala Sekolah
                    </button>
                </div>
            </div>
        </div>

        <div class="text-center text-xs text-slate-500">
            &copy; 2026 SD Negeri Jarak 2 Jombang. Sistem Pendukung Keputusan SAW.
        </div>
    </div>

    <script>
        function fillAccount(email) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password';
        }
    </script>
</body>
</html>
