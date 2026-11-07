@php
    $siteName = $siteSettings['site_name'] ?? config('app.name');

    $adminNav = [
        ['group' => 'Ringkasan', 'items' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'match' => 'admin.dashboard'],
        ]],
        ['group' => 'Konten', 'items' => [
            ['label' => 'Berita & Pengumuman', 'url' => route('admin.posts.index'), 'match' => 'admin.posts.*'],
            ['label' => 'Produk Hukum', 'url' => route('admin.legal-products.index'), 'match' => 'admin.legal-products.*'],
            ['label' => 'Dokumen', 'url' => route('admin.documents.index'), 'match' => 'admin.documents.*'],
            ['label' => 'Media', 'url' => route('admin.media.index'), 'match' => 'admin.media.*'],
        ]],
        ['group' => 'Struktur', 'items' => [
            ['label' => 'Pimpinan Dewan', 'url' => route('admin.pimpinan-dewan.index'), 'match' => 'admin.pimpinan-dewan.*'],
            ['label' => 'Distribusi Dana', 'url' => route('admin.distribusi-dana'), 'match' => 'admin.distribusi-dana.*'],
            ['label' => 'Aspirasi', 'url' => route('admin.aspirasi.index'), 'match' => 'admin.aspirasi.*'],
            ['label' => 'Alat Kelengkapan', 'url' => route('admin.units.index'), 'match' => 'admin.units.*'],
            ['label' => 'Periode', 'url' => route('admin.periods.index'), 'match' => 'admin.periods.*'],
            ['label' => 'Kategori Dokumen', 'url' => route('admin.document-categories.index'), 'match' => 'admin.document-categories.*'],
        ]],
        ['group' => 'Sistem', 'items' => [
            ['label' => 'Pengaturan', 'url' => route('admin.settings.edit'), 'match' => 'admin.settings.*'],
        ]],
    ];

    $navItems = collect($adminNav)->flatMap(fn ($group) => $group['items']);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') · {{ $siteName }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased" data-media-upload-url="{{ route('admin.media.store') }}">
    <div class="flex min-h-screen">
        <aside class="hidden w-64 shrink-0 flex-col bg-[#0B2A5B] lg:flex">
            <div class="border-b border-white/10 px-5 py-5">
                <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-blue-300">Panel Admin</p>
                <p class="mt-1 truncate text-sm font-semibold text-white">{{ $siteName }}</p>
            </div>

            <nav aria-label="Navigasi admin" class="flex-1 overflow-y-auto px-3 py-4">
                @foreach ($adminNav as $group)
                    <div @class(['mb-5' => ! $loop->last])>
                        <p class="px-3 pb-2 text-[10px] font-semibold uppercase tracking-[0.16em] text-blue-300/80">
                            {{ $group['group'] }}
                        </p>

                        <ul class="space-y-0.5">
                            @foreach ($group['items'] as $item)
                                <li>
                                    <a href="{{ $item['url'] }}"
                                       @class([
                                           'block rounded-md border-l-2 px-3 py-2 text-sm transition',
                                           'border-[#F2B31A] bg-white/10 font-semibold text-white' => request()->routeIs($item['match']),
                                           'border-transparent font-medium text-blue-100 hover:border-white/30 hover:bg-white/5 hover:text-white' => ! request()->routeIs($item['match']),
                                       ])>
                                        {{ $item['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </nav>

            <div class="border-t border-white/10 px-3 py-3">
                <a href="{{ route('home') }}" target="_blank" rel="noopener"
                   class="block rounded-md px-3 py-2 text-sm font-medium text-blue-100 hover:bg-white/5 hover:text-white">
                    Lihat situs
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                            class="block w-full rounded-md px-3 py-2 text-left text-sm font-medium text-blue-200 hover:bg-white/5 hover:text-white">
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-20 border-b border-slate-200 bg-white">
                <div class="mx-auto flex max-w-[1400px] items-center justify-between gap-4 px-4 py-3 sm:px-6">
                    <div class="min-w-0">
                        <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">Admin / {{ $siteName }}</p>
                        <p class="truncate text-base font-semibold text-slate-900">@yield('heading', 'Dashboard')</p>
                        @hasSection('subheading')
                            <p class="truncate text-xs text-slate-500">@yield('subheading')</p>
                        @endif
                    </div>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('home') }}" target="_blank" rel="noopener"
                           class="hidden text-xs font-medium text-slate-600 hover:text-[#0B3C8D] sm:block">
                            Lihat situs
                        </a>

                        <div class="flex items-center gap-2 border-l border-slate-200 pl-4">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#0B3C8D] text-xs font-semibold text-white">
                                {{ \Illuminate\Support\Str::substr(auth()->user()->name ?? 'A', 0, 1) }}
                            </span>
                            <div class="hidden text-xs leading-tight sm:block">
                                <p class="font-medium text-slate-800">{{ auth()->user()->name }}</p>
                                <p class="text-slate-500">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <nav aria-label="Navigasi admin seluler"
                 class="flex gap-1 overflow-x-auto border-b border-slate-200 bg-white px-3 py-2 lg:hidden">
                @foreach ($navItems as $item)
                    <a href="{{ $item['url'] }}"
                       @class([
                           'whitespace-nowrap rounded-md px-3 py-1.5 text-xs font-medium transition',
                           'bg-[#0B3C8D] text-white' => request()->routeIs($item['match']),
                           'text-slate-600 hover:bg-slate-100' => ! request()->routeIs($item['match']),
                       ])>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <main class="flex-1 px-4 py-7 sm:px-6">
                <div class="mx-auto max-w-[1400px]">
                    @if (session('success'))
                        <div role="status" class="mb-5 rounded-lg border border-emerald-200 border-l-4 border-l-emerald-500 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div role="alert" class="mb-5 rounded-lg border border-red-200 border-l-4 border-l-red-500 bg-red-50 px-4 py-3 text-sm text-red-800">
                            <p class="font-semibold">Periksa kembali isian berikut:</p>
                            <ul class="mt-1 list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
