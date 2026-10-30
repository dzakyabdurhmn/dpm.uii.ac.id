@extends('layouts.admin')

@section('title', 'Kategori Dokumen')
@section('heading', 'Kategori Dokumen')
@section('subheading', 'Grup menentukan di menu mana kategori tampil (Dana, Laporan, Keputusan)')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <p class="text-sm text-slate-600">Kategori grup "Dana" otomatis muncul di halaman /dana.</p>
        <a href="{{ route('admin.document-categories.create') }}"
           class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
            Tambah kategori
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Kategori</th>
                    <th class="px-5 py-3">Grup</th>
                    <th class="px-5 py-3">Dokumen</th>
                    <th class="px-5 py-3">Urutan</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($categories as $category)
                    <tr>
                        <td class="px-5 py-3">
                            <p class="font-medium text-slate-900">{{ $category->name }}</p>
                            <p class="text-xs text-slate-400">{{ $category->slug }}</p>
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $category->group ?? '—' }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $category->documents_count }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $category->sort_order }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.document-categories.edit', $category) }}"
                                   class="rounded-lg bg-[#0B3C8D] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#08285C]">
                                    Ubah
                                </a>
                                <form method="POST" action="{{ route('admin.document-categories.destroy', $category) }}"
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
                        <td colspan="5" class="px-5 py-8 text-center text-sm text-slate-500">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
