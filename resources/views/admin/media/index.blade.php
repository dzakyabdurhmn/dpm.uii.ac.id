@extends('layouts.admin')

@section('title', 'Media')
@section('heading', 'Media library')
@section('subheading', 'Gambar dan berkas yang dipakai di situs')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[320px_1fr]">
        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-semibold text-slate-900">Unggah berkas</h2>
            <p class="mt-1 text-xs text-slate-500">
                Berkas disimpan di <code class="rounded bg-slate-100 px-1">public/uploads</code> sehingga tetap dilayani
                langsung oleh web server (tanpa S3 atau symlink).
            </p>

            <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="mt-4 space-y-3">
                @csrf

                <input type="file" name="file" required
                       accept=".jpg,.jpeg,.png,.webp,.gif,.svg,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">

                <input type="text" name="alt_text" maxlength="150" placeholder="Teks alternatif (opsional)"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">

                <button type="submit" class="w-full rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-800">
                    Unggah
                </button>
            </form>

            <div class="mt-5 border-t border-slate-100 pt-4">
                <a href="{{ route('admin.media.index') }}"
                   @class(['text-xs font-medium', 'text-brand-700' => ! $imagesOnly, 'text-slate-500 hover:text-slate-800' => $imagesOnly])>
                    Semua berkas
                </a>
                <span class="mx-2 text-slate-300">|</span>
                <a href="{{ route('admin.media.index', ['images' => 1]) }}"
                   @class(['text-xs font-medium', 'text-brand-700' => $imagesOnly, 'text-slate-500 hover:text-slate-800' => ! $imagesOnly])>
                    Hanya gambar
                </a>
            </div>
        </div>

        <div>
            @if ($media->isEmpty())
                <p class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-sm text-slate-500">
                    Belum ada berkas yang diunggah.
                </p>
            @else
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($media as $item)
                        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                            <div class="flex h-36 items-center justify-center bg-slate-50">
                                @if ($item->isImage())
                                    <img src="{{ $item->url }}" alt="{{ $item->alt_text ?: $item->name }}"
                                         class="h-full w-full object-cover" loading="lazy">
                                @else
                                    <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        {{ pathinfo($item->name, PATHINFO_EXTENSION) ?: 'file' }}
                                    </span>
                                @endif
                            </div>

                            <div class="space-y-2 p-4">
                                <p class="truncate text-sm font-medium text-slate-900" title="{{ $item->name }}">{{ $item->name }}</p>
                                <p class="text-xs text-slate-500">{{ $item->human_size }} · {{ $item->created_at->translatedFormat('d M Y') }}</p>

                                <div class="flex items-center gap-2 pt-1">
                                    <button type="button" data-copy="{{ $item->url }}"
                                            class="rounded-lg border border-slate-300 px-2.5 py-1 text-xs text-slate-700 hover:bg-slate-50">
                                        Salin URL
                                    </button>

                                    <form method="POST" action="{{ route('admin.media.destroy', $item) }}"
                                          data-confirm="Hapus berkas &quot;{{ $item->name }}&quot;?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-red-200 px-2.5 py-1 text-xs text-red-600 hover:bg-red-50">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-6">{{ $media->links() }}</div>
            @endif
        </div>
    </div>
@endsection
