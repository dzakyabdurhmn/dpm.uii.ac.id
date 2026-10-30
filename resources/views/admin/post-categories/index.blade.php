@extends('layouts.admin')

@section('title', 'Kategori Berita')
@section('heading', 'Kategori Berita')
@section('subheading', 'Kategori menentukan tab berita & pengumuman di situs')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <p class="text-sm text-slate-600">Kategori "pengumuman" dipakai halaman /pengumuman.</p>
        <a href="{{ route('admin.post-categories.create') }}"
           class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
            Tambah kategori
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Kategori</th>
                    <th class="px-5 py-3">Slug</th>
                    <th class="px-5 py-3">Berita</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($categories as $category)
                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900">{{ $category->name }}</td>
                        <td class="px-5 py-3 text-xs text-slate-500">{{ $category->slug }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $category->posts_count }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.post-categories.edit', $category) }}"
                                   class="rounded-lg bg-[#0B3C8D] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#08285C]">
                                    Ubah
                                </a>
                                <form method="POST" action="{{ route('admin.post-categories.destroy', $category) }}"
                                      onsubmit="return confirm('Hapus kategori {{ $category->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-sm text-slate-500">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
