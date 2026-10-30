@extends('layouts.admin')

@section('title', 'Periode')
@section('heading', 'Periode Kepengurusan')
@section('subheading', 'Arsip periode lama tetap tersimpan')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <p class="text-sm text-slate-600">Hanya satu periode yang aktif pada satu waktu.</p>
        <a href="{{ route('admin.periods.create') }}"
           class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
            Tambah periode
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Periode</th>
                    <th class="px-5 py-3">Mulai</th>
                    <th class="px-5 py-3">Selesai</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($periods as $period)
                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900">{{ $period->name }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $period->starts_on?->translatedFormat('d M Y') ?? '—' }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $period->ends_on?->translatedFormat('d M Y') ?? '—' }}</td>
                        <td class="px-5 py-3">
                            <span @class([
                                'rounded-full px-2 py-0.5 text-[11px] font-medium',
                                'bg-emerald-50 text-emerald-700' => $period->is_active,
                                'bg-slate-100 text-slate-600' => ! $period->is_active,
                            ])>{{ $period->is_active ? 'Aktif' : 'Arsip' }}</span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-2">
                                @unless ($period->is_active)
                                    <form method="POST" action="{{ route('admin.periods.activate', $period) }}">
                                        @csrf
                                        <button type="submit" class="rounded-lg border border-[#0B3C8D] px-3 py-1.5 text-xs font-semibold text-[#0B3C8D] hover:bg-blue-50">
                                            Aktifkan
                                        </button>
                                    </form>
                                @endunless

                                <a href="{{ route('admin.periods.edit', $period) }}"
                                   class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-200">
                                    Ubah
                                </a>

                                @unless ($period->is_active)
                                    <form method="POST" action="{{ route('admin.periods.destroy', $period) }}"
                                          onsubmit="return confirm('Hapus periode {{ $period->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">
                                            Hapus
                                        </button>
                                    </form>
                                @endunless
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-sm text-slate-500">Belum ada periode.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $periods->links() }}</div>
@endsection
