@extends('layouts.admin')

@section('title', 'Ubah '.$config['title'])
@section('heading', 'Ubah '.$config['title'])
@section('subheading', 'Halaman /tentang/'.$section)

@section('content')
    <form method="POST" action="{{ route('admin.contents.update', $section) }}" class="space-y-5">
        @csrf
        @method('PUT')

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Bagian</p>
            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $config['title'] }}</p>
            <p class="text-xs text-slate-500">{{ $config['subtitle'] }}</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <label for="body" class="block text-sm font-medium text-slate-700">Isi halaman</label>
            <p class="mt-1 text-xs text-slate-500">
                Editor WYSIWYG — mendukung heading, bold, italic, list, blockquote, link, dan gambar.
            </p>

            <textarea id="body" name="body" data-rich-editor rows="16"
                      placeholder="Tulis isi halaman…"
                      class="mt-3 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 font-mono text-sm text-slate-800">{{ old('body', $content->body ?? '') }}</textarea>

            @error('body')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
                Simpan
            </button>
            <a href="{{ route('admin.contents.index') }}" class="text-sm text-slate-600 hover:underline">Kembali</a>
            <a href="{{ route('about.show', $section) }}" target="_blank" rel="noopener" class="text-sm text-[#0B3C8D] hover:underline">
                Lihat halaman
            </a>
        </div>
    </form>
@endsection