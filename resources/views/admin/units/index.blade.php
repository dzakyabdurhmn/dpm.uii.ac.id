@extends('layouts.admin')

@section('title', 'Alat Kelengkapan')
@section('heading', 'Alat Kelengkapan')
@section('subheading', 'Badan, lembaga, dan komisi DPM UII — tambah unit baru dan kelola anggotanya')

@section('content')
    @php
        $periodName = $adminPeriod?->name;
    @endphp

    <div class="mb-5 flex flex-wrap items-start justify-between gap-3 rounded-xl border border-slate-200 bg-white px-5 py-4">
        <div class="max-w-2xl text-sm text-slate-600">
            <p class="font-semibold text-slate-900">Unit bisa ditambah kapan saja.</p>
            <p class="mt-1">
                Unit yang <strong>sudah punya anggota tidak bisa dihapus</strong> — hapus atau pindahkan anggotanya
                lebih dulu. Anggota yang kamu tambahkan otomatis masuk ke periode kerja
                <strong>{{ $periodName ?? 'yang dipilih' }}</strong> di header.
            </p>
        </div>

        <a href="{{ route('admin.units.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#08285C]">
            <span aria-hidden="true">+</span> Tambah alat kelengkapan
        </a>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($units as $unit)
            @php
                $membersInPeriod = $unit->members_in_period_count ?? 0;
                $hasMembers = $unit->members_all_count > 0;
            @endphp

            <article class="flex flex-col rounded-xl border border-slate-200 bg-white p-5">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-400">{{ $unit->type }}</p>
                        <h2 class="mt-1 truncate text-base font-semibold text-slate-900">{{ $unit->short_name }}</h2>
                        @if ($unit->abbreviation && $unit->abbreviation !== $unit->name)
                            <p class="truncate text-xs text-slate-500">{{ $unit->name }}</p>
                        @endif
                    </div>

                    <span @class([
                        'shrink-0 rounded-full px-2 py-0.5 text-[11px] font-medium',
                        'bg-emerald-50 text-emerald-700' => $unit->is_active,
                        'bg-slate-100 text-slate-600' => ! $unit->is_active,
                    ])>{{ $unit->is_active ? 'Tampil' : 'Disembunyikan' }}</span>
                </div>

                <dl class="mt-4 grid grid-cols-2 gap-2 text-xs">
                    <div class="rounded-lg bg-slate-50 px-3 py-2">
                        <dt class="text-slate-500">Anggota {{ $periodName ?? 'periode ini' }}</dt>
                        <dd class="mt-0.5 text-lg font-semibold tabular-nums text-slate-900">{{ $membersInPeriod }}</dd>
                    </div>
                    <div class="rounded-lg bg-slate-50 px-3 py-2">
                        <dt class="text-slate-500">Total aktif</dt>
                        <dd class="mt-0.5 text-lg font-semibold tabular-nums text-slate-900">{{ $unit->members_count }}</dd>
                    </div>
                </dl>

                <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-4">
                    <a href="{{ route('admin.units.edit', $unit) }}"
                       class="rounded-lg bg-[#0B3C8D] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#08285C]">
                        Kelola anggota
                    </a>
                    <a href="{{ $unit->url }}" target="_blank" rel="noopener"
                       class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-200">
                        Lihat halaman
                    </a>

                    @if ($hasMembers)
                        <span class="ml-auto inline-flex items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-medium text-slate-400"
                              title="Tidak bisa dihapus: unit masih punya anggota">
                            <span aria-hidden="true">🔒</span> Terkunci
                        </span>
                    @else
                        <form method="POST" action="{{ route('admin.units.destroy', $unit) }}" class="ml-auto"
                              onsubmit="return confirm('Hapus unit {{ $unit->short_name }}? Tindakan ini tidak bisa dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg px-2 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">
                                Hapus unit
                            </button>
                        </form>
                    @endif
                </div>
            </article>
        @empty
            <div class="rounded-xl border border-dashed border-slate-300 bg-white px-5 py-10 text-center md:col-span-2 xl:col-span-3">
                <p class="text-sm font-semibold text-slate-700">Belum ada alat kelengkapan.</p>
                <p class="mt-1 text-sm text-slate-500">Tambahkan unit pertama lewat tombol di atas.</p>
            </div>
        @endforelse
    </div>
@endsection
