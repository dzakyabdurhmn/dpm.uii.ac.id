@extends('layouts.admin')

@section('title', 'Dokumen')
@section('heading', 'Dokumen & laporan')
@section('subheading', 'Produk hukum, surat keputusan, laporan triwulan')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <form method="GET" action="{{ route('admin.documents.index') }}" class="flex flex-wrap gap-2">
            <input type="search" name="q" value="{{ $search }}" placeholder="Cari judul dokumen…"
                   class="w-60 rounded-lg border border-slate-300 px-3 py-2 text-sm">

            <select name="kategori" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Filter
            </button>
        </form>

        <a href="{{ route('admin.documents.create') }}"
           class="rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-800">
            Dokumen baru
        </a>
    </div>

    <div class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white">
        @if ($documents->isEmpty())
            <p class="p-10 text-center text-sm text-slate-500">Belum ada dokumen.</p>
        @else
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3 font-medium">Judul</th>
                        <th class="px-5 py-3 font-medium">Kategori</th>
                        <th class="px-5 py-3 font-medium">Periode</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Unduhan</th>
                        <th class="px-5 py-3 text-right font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($documents as $document)
                        <tr>
                            <td class="px-5 py-3">
                                <a href="{{ route('admin.documents.edit', $document) }}" class="font-medium text-slate-900 hover:text-brand-700">
                                    {{ $document->title }}
                                </a>
                                <p class="text-xs text-slate-500">{!! $document->extension !!} · {{ $document->human_size }}</p>
                            </td>
                            <td class="px-5 py-3 text-slate-600">{{ $document->category?->name ?? '—' }}</td>
                            <td class="px-5 py-3 text-slate-600">
                                {{ $document->year ?? '—' }}
                                @if ($document->quarter_label)
                                    · {{ $document->quarter_label }}
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <span @class([
                                    'rounded-full px-2 py-0.5 text-xs font-medium',
                                    'bg-emerald-50 text-emerald-700' => $document->isPublished(),
                                    'bg-slate-100 text-slate-600' => ! $document->isPublished(),
                                ])>{{ $document->isPublished() ? 'Terbit' : 'Draf' }}</span>
                            </td>
                            <td class="px-5 py-3 text-slate-600">{{ $document->downloads }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    @if ($document->download_url)
                                        <a href="{{ route('documents.download', $document) }}" target="_blank" rel="noopener"
                                           class="rounded-lg border border-slate-300 px-2.5 py-1 text-xs text-slate-600 hover:bg-slate-50">
                                            Buka
                                        </a>
                                    @endif

                                    <form method="POST" action="{{ route('admin.documents.destroy', $document) }}"
                                          data-confirm="Hapus dokumen &quot;{{ $document->title }}&quot;?">
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

    <div class="mt-6">{{ $documents->links() }}</div>
@endsection
