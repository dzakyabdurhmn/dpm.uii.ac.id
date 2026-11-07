@extends('layouts.admin')

@section('title', 'Kelola '.$unit->short_name)
@section('heading', 'Kelola '.$unit->short_name)
@section('subheading', 'Alat kelengkapan DPM UII — keterangan unit dan anggotanya')

@section('content')
    <div class="grid gap-6 lg:grid-cols-3">
        <form method="POST" action="{{ route('admin.units.update', $unit) }}"
              class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5 lg:col-span-1">
            @csrf
            @method('PUT')

            <div class="grid gap-3 sm:grid-cols-2">
                <label for="type" class="block text-xs font-medium text-slate-600">Tipe</label>
                <select id="type" name="type" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    @foreach (\App\Models\OrganizationalUnit::TYPES as $type)
                        <option value="{{ $type }}" @selected(old('type', $unit->type) === $type)>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="description" class="block text-xs font-medium text-slate-600">Penjelasan unit</label>
                <textarea id="description" name="description" rows="6"
                          placeholder="{{ $unit->short_name }} adalah ..."
                          class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('description', $unit->description) }}</textarea>
                @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label for="sort_order" class="block text-xs font-medium text-slate-600">Urutan</label>
                    <input id="sort_order" name="sort_order" type="number" min="0"
                           value="{{ old('sort_order', $unit->sort_order ?? 0) }}"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
                <label class="mt-6 flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $unit->is_active ?? true))>
                    Tampilkan di situs
                </label>
            </div>

            <div class="flex items-center gap-3 pt-1">
                <button type="submit" class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
                    Simpan keterangan
                </button>
                <a href="{{ route('admin.units.index') }}" class="text-sm text-slate-600 hover:underline">Kembali</a>
            </div>
        </form>

        <div class="space-y-4 lg:col-span-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <h2 class="text-sm font-semibold text-slate-900">Anggota</h2>

                @if ($officials->isEmpty())
                    <p class="mt-2 text-sm text-slate-500">Belum ada anggota. Tambahkan lewat form di bawah.</p>
                @else
                    <div class="mt-4 space-y-8">
                        @foreach ($periods as $period)
                            @php($members = $officials->where('period_id', $period->id))
                            @continue($members->isEmpty())

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Periode {{ $period->name }}
                                </p>
                                <div class="mt-3 space-y-3">
                                    @foreach ($members as $official)
                                        @include('admin.units.partials.official-row', ['official' => $official])
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($officials->whereNull('period_id')->isNotEmpty())
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Tanpa periode</p>
                            <div class="mt-3 space-y-3">
                                @foreach ($officials->whereNull('period_id') as $official)
                                    @include('admin.units.partials.official-row', ['official' => $official])
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-semibold text-slate-900">Tambah anggota</h2>

            <form method="POST" action="{{ route('admin.units.officials.store', $unit) }}"
                  enctype="multipart/form-data" class="mt-4 grid gap-3 sm:grid-cols-2">
                @csrf

                @include('admin.units.partials.official-fields', ['official' => null])

                <div class="sm:col-span-2">
                    <button type="submit" class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
                        Tambah anggota
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection