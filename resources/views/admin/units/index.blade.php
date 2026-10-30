@extends('layouts.admin')

@section('title', 'Alat Kelengkapan')
@section('heading', 'Alat Kelengkapan')
@section('subheading', 'Daftar tetap badan dan lembaga DPM UII — kelola anggotanya di sini')

@section('content')
    <p class="mb-4 text-sm text-slate-600">
        Alat kelengkapan tidak bisa ditambah atau dihapus. Yang bisa diubah adalah keterangan unit dan data anggotanya
        (foto, nama, deskripsi, periode).
    </p>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Unit</th>
                    <th class="px-5 py-3">Tipe</th>
                    <th class="px-5 py-3">Anggota</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($units as $unit)
                    <tr>
                        <td class="px-5 py-3">
                            <p class="font-medium text-slate-900">{{ $unit->short_name }}</p>
                            @if ($unit->abbreviation && $unit->abbreviation !== $unit->name)
                                <p class="text-xs text-slate-500">{{ $unit->name }}</p>
                            @endif
                            <p class="text-xs text-slate-400">/unit/{{ $unit->slug }}</p>
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $unit->type }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $unit->officials_count }}</td>
                        <td class="px-5 py-3">
                            <span @class([
                                'rounded-full px-2 py-0.5 text-[11px] font-medium',
                                'bg-emerald-50 text-emerald-700' => $unit->is_active,
                                'bg-slate-100 text-slate-600' => ! $unit->is_active,
                            ])>{{ $unit->is_active ? 'Tampil' : 'Disembunyikan' }}</span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ $unit->url }}" target="_blank" rel="noopener"
                                   class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-200">
                                    Lihat
                                </a>
                                <a href="{{ route('admin.units.edit', $unit) }}"
                                   class="rounded-lg bg-[#0B3C8D] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#08285C]">
                                    Kelola
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-sm text-slate-500">Belum ada unit.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
