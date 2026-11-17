@extends('layouts.admin')

@section('title', $isCreating ? 'Tambah alat kelengkapan' : 'Kelola '.$unit->short_name)
@section('heading', $isCreating ? 'Tambah alat kelengkapan' : 'Kelola '.$unit->short_name)
@section('subheading', $isCreating
    ? 'Buat unit baru; anggotanya bisa ditambahkan setelah unit tersimpan'
    : 'Identitas unit dan daftar anggotanya')

@section('content')
    @php
        $periods = $adminPeriods ?? collect();
        $activePeriodId = $adminPeriod?->id;

        // Periode kerja admin tampil paling atas, lalu periode lain, terakhir yang tanpa periode.
        $orderedPeriods = $periods->sortByDesc(fn ($p) => ($p->id === $activePeriodId ? '2' : '1').$p->name)->values();
    @endphp

    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('admin.units.index') }}" class="text-sm font-medium text-slate-600 hover:text-[#0B3C8D]">
            ← Semua alat kelengkapan
        </a>

        <div class="flex flex-wrap items-center gap-2">
            @unless ($isCreating)
                <a href="{{ $unit->url }}" target="_blank" rel="noopener"
                   class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-200">
                    Lihat halaman publik
                </a>

                @if ($officials->isEmpty())
                    <form method="POST" action="{{ route('admin.units.destroy', $unit) }}"
                          onsubmit="return confirm('Hapus unit {{ $unit->short_name }}? Tindakan ini tidak bisa dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="rounded-lg px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">
                            Hapus unit
                        </button>
                    </form>
                @else
                    <span class="rounded-lg bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-500"
                          title="Unit masih punya {{ $officials->count() }} anggota, jadi tidak bisa dihapus">
                        🔒 Unit terkunci — masih punya {{ $officials->count() }} anggota
                    </span>
                @endif
            @endunless
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Identitas unit --}}
        <form method="POST"
              action="{{ $isCreating ? route('admin.units.store') : route('admin.units.update', $unit) }}"
              class="space-y-4 self-start rounded-2xl border border-slate-200 bg-white p-5">
            @csrf
            @unless ($isCreating)
                @method('PUT')
            @endunless

            <div>
                <h2 class="text-sm font-semibold text-slate-900">Identitas unit</h2>
                <p class="mt-1 text-xs text-slate-500">Tampil di halaman Alat Kelengkapan dan Beranda.</p>
            </div>

            <div>
                <label for="name" class="block text-xs font-medium text-slate-600">Nama lengkap</label>
                <input id="name" name="name" type="text" required value="{{ old('name', $unit->name) }}"
                       placeholder="Badan Legislasi"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label for="abbreviation" class="block text-xs font-medium text-slate-600">Singkatan</label>
                    <input id="abbreviation" name="abbreviation" type="text" value="{{ old('abbreviation', $unit->abbreviation) }}"
                           placeholder="Baleg"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>

                <div>
                    <label for="type" class="block text-xs font-medium text-slate-600">Tipe</label>
                    <select id="type" name="type" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        @foreach (\App\Models\OrganizationalUnit::TYPES as $type)
                            <option value="{{ $type }}" @selected(old('type', $unit->type) === $type)>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label for="slug" class="block text-xs font-medium text-slate-600">Slug URL</label>
                <div class="mt-1 flex items-center rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <span class="shrink-0 text-slate-400">/unit/</span>
                    <input id="slug" name="slug" type="text" value="{{ old('slug', $unit->slug) }}"
                           placeholder="otomatis-dari-nama"
                           class="w-full border-0 p-0 text-sm focus:outline-none focus:ring-0">
                </div>
                <p class="mt-1 text-xs text-slate-400">Kosongkan untuk dibuat otomatis dari nama.</p>
            </div>

            <div>
                <label for="description" class="block text-xs font-medium text-slate-600">Deskripsi singkat</label>
                <textarea id="description" name="description" rows="4"
                          placeholder="Media dan Kesekretariatan"
                          class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('description', $unit->description) }}</textarea>
                <p class="mt-1 text-xs text-slate-400">Dipakai sebagai subjudul di kartu Beranda dan hero halaman unit.</p>
                @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="logo" class="block text-xs font-medium text-slate-600">Logo (opsional)</label>
                @if ($unit->logo_path)
                    <img src="{{ asset($unit->logo_path) }}" alt="Logo {{ $unit->short_name }}"
                         class="mt-2 h-16 w-16 rounded-lg border border-slate-200 bg-slate-50 object-contain p-1">
                @endif
                <input id="logo" name="logo" type="file" accept="image/*"
                       class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                @error('logo') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label for="sort_order" class="block text-xs font-medium text-slate-600">Urutan tampil</label>
                    <input id="sort_order" name="sort_order" type="number" min="0"
                           value="{{ old('sort_order', $unit->sort_order ?? 0) }}"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
                <label class="mt-6 flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $unit->is_active ?? true))>
                    Tampilkan di situs
                </label>
            </div>

            <button type="submit"
                    class="w-full rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
                {{ $isCreating ? 'Simpan unit' : 'Simpan identitas' }}
            </button>
        </form>

        @unless ($isCreating)
            <div class="space-y-4 lg:col-span-2">
                {{-- Tambah anggota --}}
                <div class="rounded-2xl border border-[#0B3C8D]/20 bg-white p-5">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <h2 class="text-sm font-semibold text-slate-900">Tambah anggota</h2>
                        @if ($adminPeriod)
                            <span class="rounded-full bg-[#0B3C8D]/10 px-2.5 py-1 text-[11px] font-semibold text-[#0B3C8D]">
                                Otomatis masuk periode {{ $adminPeriod->name }}
                            </span>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('admin.units.officials.store', $unit) }}"
                          enctype="multipart/form-data" class="mt-4 grid gap-3 sm:grid-cols-2">
                        @csrf

                        @include('admin.units.partials.official-fields', [
                            'official' => null,
                            'periods' => $orderedPeriods,
                            'defaultPeriodId' => $activePeriodId,
                        ])

                        <div class="sm:col-span-2">
                            <button type="submit"
                                    class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
                                Tambah anggota
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Daftar anggota per periode --}}
                @if ($officials->isEmpty())
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-5 py-10 text-center">
                        <p class="text-sm font-semibold text-slate-700">Belum ada anggota.</p>
                        <p class="mt-1 text-sm text-slate-500">Anggota yang kamu tambahkan akan muncul di halaman publik.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($orderedPeriods as $period)
                            @php($members = $officials->where('period_id', $period->id))
                            @continue($members->isEmpty())

                            <section class="rounded-2xl border border-slate-200 bg-white p-5">
                                <div class="flex items-center justify-between gap-3">
                                    <h2 class="text-sm font-semibold text-slate-900">Periode {{ $period->name }}</h2>
                                    <div class="flex items-center gap-2">
                                        @if ($period->is_active)
                                            <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-medium text-emerald-700">
                                                Periode aktif
                                            </span>
                                        @endif
                                        <span class="text-xs text-slate-500">{{ $members->count() }} anggota</span>
                                    </div>
                                </div>

                                <div class="mt-3 space-y-3">
                                    @foreach ($members as $official)
                                        @include('admin.units.partials.official-row', [
                                            'official' => $official,
                                            'periods' => $orderedPeriods,
                                            'defaultPeriodId' => $official->period_id,
                                        ])
                                    @endforeach
                                </div>
                            </section>
                        @endforeach

                        @if ($officials->whereNull('period_id')->isNotEmpty())
                            <section class="rounded-2xl border border-slate-200 bg-white p-5">
                                <div class="flex items-center justify-between gap-3">
                                    <h2 class="text-sm font-semibold text-slate-900">Tanpa periode</h2>
                                    <span class="text-xs text-slate-500">{{ $officials->whereNull('period_id')->count() }} anggota</span>
                                </div>
                                <p class="mt-1 text-xs text-slate-500">
                                    Anggota tanpa periode tetap tampil di publik pada semua periode.
                                </p>

                                <div class="mt-3 space-y-3">
                                    @foreach ($officials->whereNull('period_id') as $official)
                                        @include('admin.units.partials.official-row', [
                                            'official' => $official,
                                            'periods' => $orderedPeriods,
                                            'defaultPeriodId' => null,
                                        ])
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    </div>
                @endif
            </div>
        @endunless
    </div>
@endsection
