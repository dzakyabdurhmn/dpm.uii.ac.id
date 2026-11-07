@extends('layouts.admin')

@section('title', 'Tugas · '.$pimpinan->nama)
@section('heading', 'Tugas '.$pimpinan->nama)
@section('subheading', 'Rincian tugas dan wewenang pimpinan dewan')

@section('content')
    <div class="flex items-center justify-between gap-3 mb-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-4">
            <h2 class="text-sm font-semibold text-slate-900">{{ $pimpinan->jabatan }}: {{ $pimpinan->nama }}</h2>
            <p class="text-xs text-slate-500">Jumlah tugas: {{ $tugas->count() }}</p>
        </div>

        <a href="{{ route('admin.pimpinan-dewan.index') }}"
           class="text-sm text-[#0B3C8D] hover:underline">← Kembali ke daftar pimpinan</a>
    </div>

    <div class="space-y-4">
        <form method="POST" action="{{ route('admin.pimpinan-dewan.tugas.store', $pimpinan) }}"
              class="rounded-2xl border border-slate-200 bg-white p-4">
            @csrf
            <div class="grid gap-3 sm:grid-cols-2 items-end">
                <div class="sm:col-span-2">
                    <label for="tugas" class="block text-xs font-medium text-slate-600">Deskripsi tugas <span class="text-red-500">*</span></label>
                    <textarea id="tugas" name="tugas" rows="3" required
                              class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></textarea>
                </div>
                <div>
                    <label for="sort_order" class="block text-xs font-medium text-slate-600">Urutan</label>
                    <input id="sort_order" name="sort_order" type="number" min="0"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
                <button type="submit"
                        class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
                    Tambah tugas
                </button>
            </div>
        </form>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Urutan</th>
                        <th class="px-5 py-3">Tugas</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($tugas as $t)
                        <tr>
                            <td class="px-5 py-3 font-medium text-slate-900">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3">{{ $t->tugas }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <form method="POST" action="{{ route('admin.pimpinan-dewan.tugas.update', [$pimpinan, $t]) }}"
                                          class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <input name="tugas" value="{{ $t->tugas }}" class="hidden">
                                        <input name="sort_order" value="{{ $t->sort_order }}" class="hidden">
                                        <button type="submit"
                                                class="rounded-lg bg-[#0B3C8D] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#08285C]">
                                            Edit
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.pimpinan-dewan.tugas.destroy', [$pimpinan, $t]) }}"
                                          class="inline"
                                          onsubmit="return confirm('Hapus tugas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-8 text-center text-sm text-slate-500">Belum ada tugas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex items-center gap-3 mt-4">
            <a href="{{ route('admin.pimpinan-dewan.index') }}" class="text-sm text-slate-600 hover:underline">Kembali ke daftar</a>
        </div>
    </div>

    @if (session('success'))
        <div class="mt-4 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
    @endif
@endsection
