@extends('layouts.admin')

@section('title', 'Ubah '.$config['title'])
@section('heading', 'Ubah '.$config['title'])
@section('subheading', 'Halaman /tentang/'.$section)

@section('content')
<form method="POST" action="{{ route('admin.page-contents.update', $section) }}" class="space-y-5">
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

    @if ($section === 'sambutan')
        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-sm font-semibold text-slate-900">Identitas Penanda Tangan</p>
            <p class="mt-1 text-xs text-slate-500">
                Ditampilkan terpisah di bawah isi sambutan. Tidak perlu ditulis ulang di editor.
            </p>

            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="signature_role" class="block text-xs font-medium text-slate-600">Jabatan</label>
                    <input id="signature_role" name="signature_role" type="text"
                           value="{{ old('signature_role', $content->signature_role ?? 'Ketua DPM UII') }}"
                           placeholder="Ketua DPM UII"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    @error('signature_role') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="signature_name" class="block text-xs font-medium text-slate-600">Nama Ketua</label>
                    <input id="signature_name" name="signature_name" type="text"
                           value="{{ old('signature_name', $content->signature_name ?? '') }}"
                           placeholder="Nama lengkap"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    @error('signature_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="signature_fakultas" class="block text-xs font-medium text-slate-600">Fakultas</label>
                    <input id="signature_fakultas" name="signature_fakultas" type="text"
                           value="{{ old('signature_fakultas', $content->signature_fakultas ?? '') }}"
                           placeholder="Fakultas Hukum"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    @error('signature_fakultas') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="signature_nim" class="block text-xs font-medium text-slate-600">NIM</label>
                    <input id="signature_nim" name="signature_nim" type="text"
                           value="{{ old('signature_nim', $content->signature_nim ?? '') }}"
                           placeholder="21522045"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    @error('signature_nim') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    @endif

    <div class="flex items-center gap-3">
        <button type="submit" class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
            Simpan
        </button>
        <a href="{{ route('admin.page-contents.index') }}" class="text-sm text-slate-600 hover:underline">Kembali</a>
        <a href="{{ route('about.show', $section) }}" target="_blank" rel="noopener" class="text-sm text-[#0B3C8D] hover:underline">
            Lihat halaman
        </a>
    </div>
</form>
@endsection