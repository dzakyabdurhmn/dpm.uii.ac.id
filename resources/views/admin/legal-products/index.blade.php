@extends('layouts.admin')

@section('title', 'Produk Hukum')
@section('heading', 'Produk hukum')
@section('subheading', 'PDKM dokumen tunggal, GBHKM per periode, PKM & PDPM per nomor dan tahun')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <form method="GET" action="{{ route('admin.legal-products.index') }}" class="flex flex-wrap gap-2">
            @if ($type)
                <input type="hidden" name="jenis" value="{{ $type }}">
            @endif
            <input type="search" name="q" value="{{ $search }}" placeholder="Cari pokok peraturan…"
                   class="w-64 rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <button type="submit" class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Cari
            </button>
        </form>

        <a href="{{ route('admin.legal-products.create', $type ? ['jenis' => $type] : []) }}"
           class="rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-800">
            Produk hukum baru
        </a>
    </div>

    <div class="mt-5 flex flex-wrap gap-2">
        <a href="{{ route('admin.legal-products.index') }}"
           @class([
               'rounded-full border px-3 py-1.5 text-xs font-medium',
               'border-brand-600 bg-brand-600 text-white' => ! $type,
               'border-slate-300 bg-white text-slate-600 hover:border-brand-400' => $type,
           ])>
            Semua ({{ $counts->sum() }})
        </a>

        @foreach (\App\Models\LegalProduct::TYPES as $key => $meta)
            <a href="{{ route('admin.legal-products.index', ['jenis' => $key]) }}"
               @class([
                   'rounded-full border px-3 py-1.5 text-xs font-medium',
                   'border-brand-600 bg-brand-600 text-white' => $type === $key,
                   'border-slate-300 bg-white text-slate-600 hover:border-brand-400' => $type !== $key,
               ])>
                {{ $meta['label'] }} ({{ $counts[$key] ?? 0 }})
            </a>
        @endforeach
    </div>

    <div class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white">
        @if ($products->isEmpty())
            <p class="p-10 text-center text-sm text-slate-500">Belum ada produk hukum pada filter ini.</p>
        @else
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3 font-medium">Jenis</th>
                        <th class="px-5 py-3 font-medium">Nomor / Periode</th>
                        <th class="px-5 py-3 font-medium">Pokok peraturan</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Unduhan</th>
                        <th class="px-5 py-3 text-right font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($products as $product)
                        <tr>
                            <td class="px-5 py-3">
                                <span class="rounded-md bg-brand-50 px-2 py-0.5 text-[11px] font-semibold text-brand-700">
                                    {{ $product->type_label }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-slate-600">
                                {{ $product->regulation_number ?? ($product->period ? 'Periode '.$product->period->name : '—') }}
                            </td>
                            <td class="px-5 py-3">
                                <a href="{{ route('admin.legal-products.edit', $product) }}"
                                   class="font-medium text-slate-900 hover:text-brand-700">
                                    {{ $product->title }}
                                </a>
                                <p class="text-xs text-slate-500">
                                    {{ $product->extension }}
                                    @if ($product->amends)
                                        · perubahan atas {{ $product->amends->heading }}
                                    @endif
                                </p>
                            </td>
                            <td class="px-5 py-3">
                                <span @class([
                                    'rounded-full px-2 py-0.5 text-xs font-medium',
                                    'bg-emerald-50 text-emerald-700' => $product->is_published,
                                    'bg-slate-100 text-slate-600' => ! $product->is_published,
                                ])>{{ $product->is_published ? 'Terbit' : 'Draf' }}</span>
                            </td>
                            <td class="px-5 py-3 text-slate-600">{{ $product->downloads }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    @if ($product->is_published && $product->hasFile())
                                        <a href="{{ route('legal-products.download', $product) }}" target="_blank" rel="noopener"
                                           class="rounded-lg border border-slate-300 px-2.5 py-1 text-xs text-slate-600 hover:bg-slate-50">
                                            Buka
                                        </a>
                                    @endif

                                    <form method="POST" action="{{ route('admin.legal-products.destroy', $product) }}"
                                          data-confirm="Hapus &quot;{{ $product->heading }}&quot;?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-red-200 px-2.5 py-1 text-xs text-red-600 hover:bg-red-50">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
@endsection
