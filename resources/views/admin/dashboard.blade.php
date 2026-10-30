@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('subheading', 'Ringkasan konten situs DPM UII')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['label' => 'Berita & Pengumuman', 'value' => $stats['posts'], 'hint' => $stats['posts_published'].' terbit'],
            ['label' => 'Produk Hukum', 'value' => $stats['legal_products'], 'hint' => 'PDKM, GBHKM, PKM, PDPM'],
            ['label' => 'Dokumen', 'value' => $stats['documents'], 'hint' => $stats['documents_published'].' terbit'],
            ['label' => 'Media', 'value' => $stats['media'], 'hint' => 'berkas terunggah'],
        ] as $card)
            <div class="rounded-lg border border-slate-200 bg-white p-5">
                <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">{{ $card['label'] }}</p>
                <p class="mt-3 text-3xl font-semibold tabular-nums text-[#0B3C8D]">{{ $card['value'] }}</p>
                <p class="mt-1 text-xs text-slate-500">{{ $card['hint'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2">
        <a href="{{ route('admin.legal-products.create') }}"
           class="rounded-lg border border-slate-200 bg-white p-5 transition hover:border-[#0B3C8D]/40">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Aksi cepat</p>
            <p class="mt-2 text-sm font-semibold text-slate-900">Unggah produk hukum baru</p>
            <p class="mt-1 text-xs text-slate-500">PDKM, GBHKM, PKM, dan PDPM wajib berupa berkas.</p>
        </a>

        <a href="{{ route('admin.documents.create') }}"
           class="rounded-lg border border-slate-200 bg-white p-5 transition hover:border-[#0B3C8D]/40">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Aksi cepat</p>
            <p class="mt-2 text-sm font-semibold text-slate-900">Unggah laporan atau dokumen</p>
            <p class="mt-1 text-xs text-slate-500">Distribusi dana, LPJ, LHA, laporan kinerja, dan keputusan.</p>
        </a>
    </div>

    <div class="mt-6 grid gap-4 lg:grid-cols-2">
        <div class="rounded-lg border border-slate-200 bg-white">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-3">
                <h2 class="text-sm font-semibold text-slate-900">Berita terbaru</h2>
                <a href="{{ route('admin.posts.index') }}" class="text-xs font-medium text-[#0B3C8D] hover:underline">Lihat semua</a>
            </div>

            @if ($latestPosts->isEmpty())
                <p class="px-5 py-6 text-sm text-slate-500">Belum ada berita.</p>
            @else
                <ul role="list" class="divide-y divide-slate-100">
                    @foreach ($latestPosts as $post)
                        <li class="flex items-center justify-between gap-3 px-5 py-3">
                            <div class="min-w-0">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="block truncate text-sm font-medium text-slate-800 hover:text-[#0B3C8D]">
                                    {{ $post->title }}
                                </a>
                                <p class="text-xs text-slate-500">{{ $post->published_at?->translatedFormat('d M Y') ?? 'Belum terbit' }}</p>
                            </div>
                            <span @class([
                                'rounded border px-2 py-0.5 text-[11px] font-medium',
                                'border-emerald-200 bg-emerald-50 text-emerald-700' => $post->isPublished(),
                                'border-slate-200 bg-slate-50 text-slate-600' => ! $post->isPublished(),
                            ])>{{ $post->isPublished() ? 'Terbit' : 'Draf' }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="rounded-lg border border-slate-200 bg-white">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-3">
                <h2 class="text-sm font-semibold text-slate-900">Produk hukum terbaru</h2>
                <a href="{{ route('admin.legal-products.index') }}" class="text-xs font-medium text-[#0B3C8D] hover:underline">Lihat semua</a>
            </div>

            @if ($latestLegalProducts->isEmpty())
                <p class="px-5 py-6 text-sm text-slate-500">Belum ada produk hukum.</p>
            @else
                <ul role="list" class="divide-y divide-slate-100">
                    @foreach ($latestLegalProducts as $product)
                        <li class="flex items-center justify-between gap-3 px-5 py-3">
                            <div class="min-w-0">
                                <a href="{{ route('admin.legal-products.edit', $product) }}" class="block truncate text-sm font-medium text-slate-800 hover:text-[#0B3C8D]">
                                    {{ $product->title }}
                                </a>
                                <p class="text-xs text-slate-500">{{ $product->heading }}</p>
                            </div>
                            <span @class([
                                'rounded border px-2 py-0.5 text-[11px] font-medium',
                                'border-emerald-200 bg-emerald-50 text-emerald-700' => $product->hasFile(),
                                'border-amber-200 bg-amber-50 text-amber-700' => ! $product->hasFile(),
                            ])>{{ $product->hasFile() ? 'Berkas ada' : 'Belum ada berkas' }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="mt-6 flex flex-wrap items-center justify-between gap-3 rounded-lg border border-slate-200 bg-white px-5 py-4">
        <div>
            <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Periode kepengurusan aktif</p>
            <p class="mt-1 text-lg font-semibold text-[#0B3C8D]">{{ $activePeriod?->name ?? 'Belum ada periode aktif' }}</p>
        </div>
        <a href="{{ route('admin.periods.index') }}" class="rounded-md bg-[#0B3C8D] px-4 py-2 text-xs font-semibold text-white hover:bg-[#08285C]">
            Kelola periode
        </a>
    </div>
@endsection
