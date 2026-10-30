@extends('layouts.admin')

@section('title', $category->exists ? 'Ubah kategori dokumen' : 'Tambah kategori dokumen')
@section('heading', $category->exists ? 'Ubah kategori' : 'Tambah kategori')
@section('subheading', 'Kategori dokumen')

@section('content')
    <form method="POST"
          action="{{ $category->exists ? route('admin.document-categories.update', $category) : route('admin.document-categories.store') }}"
          class="max-w-xl space-y-4 rounded-2xl border border-slate-200 bg-white p-5">
        @csrf
        @if ($category->exists)
            @method('PUT')
        @endif

        <div>
            <label for="name" class="block text-xs font-medium text-slate-600">Nama kategori</label>
            <input id="name" name="name" type="text" required value="{{ old('name', $category->name) }}"
                   class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="group" class="block text-xs font-medium text-slate-600">Grup navigasi</label>
            <select id="group" name="group" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                <option value="">Tanpa grup</option>
                @foreach ($groups as $group)
                    <option value="{{ $group }}" @selected(old('group', $category->group) === $group)>{{ $group }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="description" class="block text-xs font-medium text-slate-600">Deskripsi</label>
            <textarea id="description" name="description" rows="3"
                      class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('description', $category->description) }}</textarea>
        </div>

        <div>
            <label for="sort_order" class="block text-xs font-medium text-slate-600">Urutan</label>
            <input id="sort_order" name="sort_order" type="number" min="0"
                   value="{{ old('sort_order', $category->sort_order ?? 0) }}"
                   class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
                Simpan
            </button>
            <a href="{{ route('admin.document-categories.index') }}" class="text-sm text-slate-600 hover:underline">Kembali</a>
        </div>
    </form>
@endsection
