@extends('layouts.admin')

@section('title', 'Pimpinan Dewan')
@section('heading', 'Pimpinan Dewan')
@section('subheading', 'Ketua, Sekretaris Jenderal, Komisi 1–4, dan anggotanya per periode')

@section('content')
    <div class="flex items-center justify-between gap-3 mb-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-4">
            <h2 class="text-sm font-semibold text-slate-900">Periode: {{ $periode?->name ?? '-' }}</h2>
            <p class="text-xs text-slate-500">Jumlah pimpinan: {{ $pimpinan->count() }}</p>
        </div>

        <a href="{{ route('admin.pimpinan-dewan.create') }}"
           class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
            Tambah pimpinan
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Jabatan</th>
                    <th class="px-5 py-3">Nama</th>
                    <th class="px-5 py-3">Fakultas</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($pimpinan as $p)
                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900">{{ $p->jabatan }}</td>
                        <td class="px-5 py-3">{{ $p->nama }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $p->fakultas ?? '-' }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.pimpinan-dewan.edit', $p) }}"
                                   class="rounded-lg bg-[#0B3C8D] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#08285C]">
                                    Edit
                                </a>
                                <a href="{{ route('admin.pimpinan-dewan.tugas', $p) }}"
                                   class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-200">
                                    Tugas
                                </a>
                                <form method="POST" action="{{ route('admin.pimpinan-dewan.destroy', $p) }}"
                                      class="inline"
                                      onsubmit="return confirm('Hapus pimpinan ini?')">
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
                        <td colspan="4" class="px-5 py-8 text-center text-sm text-slate-500">Belum ada pimpinan dewan untuk periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if (session('success'))
        <div class="mt-4 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
    @endif
@endsection
