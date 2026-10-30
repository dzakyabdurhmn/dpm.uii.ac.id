@extends('layouts.admin')

@section('title', $period->exists ? 'Ubah periode' : 'Tambah periode')
@section('heading', $period->exists ? 'Ubah periode' : 'Tambah periode')
@section('subheading', 'Contoh format: 2026/2027')

@section('content')
    <form method="POST"
          action="{{ $period->exists ? route('admin.periods.update', $period) : route('admin.periods.store') }}"
          class="max-w-xl space-y-5">
        @csrf
        @if ($period->exists)
            @method('PUT')
        @endif

        <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5">
            <div>
                <label for="name" class="block text-xs font-medium text-slate-600">Nama periode</label>
                <input id="name" name="name" type="text" required placeholder="2026/2027"
                       value="{{ old('name', $period->name) }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="starts_on" class="block text-xs font-medium text-slate-600">Mulai</label>
                    <input id="starts_on" name="starts_on" type="date"
                           value="{{ old('starts_on', $period->starts_on?->format('Y-m-d')) }}"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label for="ends_on" class="block text-xs font-medium text-slate-600">Selesai</label>
                    <input id="ends_on" name="ends_on" type="date"
                           value="{{ old('ends_on', $period->ends_on?->format('Y-m-d')) }}"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
            </div>

            <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $period->is_active))>
                Jadikan periode aktif
            </label>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
                Simpan
            </button>
            <a href="{{ route('admin.periods.index') }}" class="text-sm text-slate-600 hover:underline">Kembali</a>
        </div>
    </form>
@endsection
