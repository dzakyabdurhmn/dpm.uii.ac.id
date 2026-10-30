@php($siteName = \App\Models\Setting::get('site_name', config('app.name')))
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk admin · {{ $siteName }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 antialiased">
    <div class="mx-auto flex min-h-screen max-w-5xl items-center px-4 py-10">
        <div class="grid w-full overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl lg:grid-cols-2">
            <div class="hidden flex-col justify-between bg-[#0B2A5B] p-10 text-white lg:flex">
                <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-blue-300">Panel admin</p>
                <div>
                    <h1 class="text-2xl font-semibold leading-tight">{{ $siteName }}</h1>
                    <p class="mt-3 text-sm leading-relaxed text-blue-100">
                        Kelola berita, halaman, produk hukum, laporan triwulan, dan media situs dalam satu tempat.
                    </p>
                </div>
                <p class="text-xs text-blue-300">&copy; {{ now()->year }} {{ $siteName }}</p>
            </div>

            <div class="p-8 sm:p-10">
                <h2 class="text-xl font-semibold text-slate-900">Masuk ke panel</h2>
                <p class="mt-1 text-sm text-slate-500">Gunakan akun administrator yang diberikan.</p>

                @if ($errors->any())
                    <div role="alert" class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.store') }}" class="mt-6 space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-medium text-slate-600">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                               autocomplete="username"
                               class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-200">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-medium text-slate-600">Kata sandi</label>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                               class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-200">
                    </div>

                    <label class="flex items-center gap-2 text-xs text-slate-600">
                        <input type="checkbox" name="remember" value="1"
                               class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-300">
                        Ingat saya
                    </label>

                    <button type="submit"
                            class="w-full rounded-lg bg-brand-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-800">
                        Masuk
                    </button>
                </form>

                <p class="mt-6 text-xs text-slate-400">
                    Pendaftaran akun dinonaktifkan. Hubungi pengelola situs bila perlu akses.
                </p>

                <a href="{{ route('home') }}" class="mt-6 inline-block text-xs font-medium text-[#0B3C8D] hover:underline">
                    Kembali ke situs
                </a>
            </div>
        </div>
    </div>
</body>
</html>
