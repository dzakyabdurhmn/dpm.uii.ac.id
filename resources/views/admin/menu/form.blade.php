@extends('layouts.admin')

@section('title', $item->exists ? 'Ubah menu' : 'Tambah menu')
@section('heading', $item->exists ? 'Ubah menu' : 'Tambah menu')
@section('subheading', 'Menu header situs')

@section('content')
    <form method="POST"
          action="{{ $item->exists ? route('admin.menu.update', $item) : route('admin.menu.store') }}"
          class="max-w-xl space-y-4 rounded-2xl border border-slate-200 bg-white p-5">
        @csrf
        @if ($item->exists)
            @method('PUT')
        @endif

        <div>
            <label for="label" class="block text-xs font-medium text-slate-600">Label</label>
            <input id="label" name="label" type="text" required value="{{ old('label', $item->label) }}"
                   placeholder="Laporan Kinerja"
                   class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            @error('label') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="url" class="block text-xs font-medium text-slate-600">URL tujuan</label>
            <input id="url" name="url" type="text" value="{{ old('url', $item->url) }}"
                   placeholder="/laporan-kinerja"
                   class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <p class="mt-1 text-xs text-slate-500">
                Halaman yang tersedia: /tentang/{sambutan|sejarah|visi-misi|struktur|kedudukan-tugas-wewenang|profil-dewan},
                /alat-kelengkapan, /produk-hukum, /dana, /laporan-kinerja, /keputusan, /berita, /pengumuman.
            </p>
        </div>

        <div class="grid gap-3 sm:grid-cols-2">
            <div>
                <label for="parent_id" class="block text-xs font-medium text-slate-600">Induk menu</label>
                <select id="parent_id" name="parent_id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option value="">Menu utama</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}" @selected((string) old('parent_id', $item->parent_id) === (string) $parent->id)>
                            {{ $parent->label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="sort_order" class="block text-xs font-medium text-slate-600">Urutan</label>
                <input id="sort_order" name="sort_order" type="number" min="0"
                       value="{{ old('sort_order', $item->sort_order ?? 0) }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>
        </div>

        <div class="grid gap-3 sm:grid-cols-2">
            <div>
                <label for="target" class="block text-xs font-medium text-slate-600">Buka di</label>
                <select id="target" name="target" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option value="_self" @selected(old('target', $item->target) === '_self')>Tab yang sama</option>
                    <option value="_blank" @selected(old('target', $item->target) === '_blank')>Tab baru</option>
                </select>
            </div>

            <label class="mt-6 flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))>
                Tampilkan
            </label>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
                Simpan
            </button>
            <a href="{{ route('admin.menu.index') }}" class="text-sm text-slate-600 hover:underline">Kembali</a>
        </div>
    </form>
@endsection
