@extends('layouts.admin')

@section('title', $category->exists ? 'Ubah kategori berita' : 'Tambah kategori berita')
@section('heading', $category->exists ? 'Ubah kategori' : 'Tambah kategori')
@section('subheading', 'Kategori berita')

@section('content')
    <form method="POST"
          action="{{ $category->exists ? route('admin.post-categories.update', $category) : route('admin.post-categories.store') }}"
          class="max-w-xl space-y-4 rounded-2xl border border-slate-200 bg-white p-5">
        @csrf
        @if ($category->exists)
            @method('PUT')
        @endif

        <div>
            <label for="name" class="block text-xs font-medium text-slate-600">Nama kategori</label>
            <input id="name" name="name" type="text" required value="{{ old('name', $category->name) }}"
                   placeholder="Kegiatan"
                   class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-xs font-medium text-slate-600">Deskripsi</label>
            <textarea id="description" name="description" rows="3"
                      class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
                Simpan
            </button>
            <a href="{{ route('admin.post-categories.index') }}" class="text-sm text-slate-600 hover:underline">Kembali</a>
        </div>
    </form>
@endsection
