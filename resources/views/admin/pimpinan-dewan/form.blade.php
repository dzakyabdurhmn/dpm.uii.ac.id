@extends('layouts.admin')

@php
    $isEdit = isset($pimpinan);
    $value = fn (string $key) => old($key, $isEdit ? $pimpinan->$key : '');
@endphp

@section('title', $isEdit ? 'Edit '.$pimpinan->nama : 'Tambah Pimpinan')
@section('heading', $isEdit ? 'Edit '.$pimpinan->nama : 'Tambah Pimpinan Dewan')
@section('subheading', 'Data pimpinan dewan dan anggota komisi')

@section('content')
    <form method="POST" action="{{ $isEdit ? route('admin.pimpinan-dewan.update', $pimpinan) : route('admin.pimpinan-dewan.store') }}"
          class="max-w-2xl space-y-4 rounded-2xl border border-slate-200 bg-white p-6">
        @csrf
        @if ($isEdit) @method('PUT') @endif

        <div class="grid gap-3 sm:grid-cols-2">
            <div>
                <label for="periode_id" class="block text-xs font-medium text-slate-600">Periode <span class="text-red-500">*</span></label>
                <select id="periode_id" name="periode_id" required
                        class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    @foreach (\App\Models\Period::query()->orderByDesc('name')->get() as $period)
                        <option value="{{ $period->id }}" @selected(old('periode_id', $isEdit ? $pimpinan->periode_id : $periode->id) === $period->id)>
                            {{ $period->name }}
                        </option>
                    @endforeach
                </select>
                @error('periode_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="jabatan" class="block text-xs font-medium text-slate-600">Jabatan <span class="text-red-500">*</span></label>
                <select id="jabatan" name="jabatan" required
                        class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    @foreach ($jabatanOptions as $jabatan)
                        <option value="{{ $jabatan }}" @selected(old('jabatan', $isEdit ? $pimpinan->jabatan : null) === $jabatan)>
                            {{ $jabatan }}
                        </option>
                    @endforeach
                </select>
                @error('jabatan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="nama" class="block text-xs font-medium text-slate-600">Nama Lengkap <span class="text-red-500">*</span></label>
            <input id="nama" name="nama" type="text" required value="{{ $value('nama') }}"
                   class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            @error('nama') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid gap-3 sm:grid-cols-2">
            <div>
                <label for="fakultas" class="block text-xs font-medium text-slate-600">Fakultas</label>
                <input id="fakultas" name="fakultas" type="text" value="{{ $value('fakultas') }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label for="prodi" class="block text-xs font-medium text-slate-600">Program Studi</label>
                <input id="prodi" name="prodi" type="text" value="{{ $value('prodi') }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>
        </div>

        <div class="grid gap-3 sm:grid-cols-2">
            <div>
                <label for="angkatan" class="block text-xs font-medium text-slate-600">Angkatan</label>
                <input id="angkatan" name="angkatan" type="text" value="{{ $value('angkatan') }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label for="nim" class="block text-xs font-medium text-slate-600">NIM</label>
                <input id="nim" name="nim" type="text" value="{{ $value('nim') }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>
        </div>

        <div class="grid gap-3 sm:grid-cols-2">
            <div>
                <label for="email" class="block text-xs font-medium text-slate-600">Email</label>
                <input id="email" name="email" type="email" value="{{ $value('email') }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label for="instagram" class="block text-xs font-medium text-slate-600">Instagram</label>
                <input id="instagram" name="instagram" type="text" placeholder="https://instagram.com/…"
                       value="{{ $value('instagram') }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>
        </div>

        <div>
            <label for="linkedin" class="block text-xs font-medium text-slate-600">LinkedIn</label>
            <input id="linkedin" name="linkedin" type="text" placeholder="https://linkedin.com/in/…"
                   value="{{ $value('linkedin') }}"
                   class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
        </div>

        <div class="grid gap-3 sm:grid-cols-2">
            <div>
                <label for="sort_order" class="block text-xs font-medium text-slate-600">Urutan</label>
                <input id="sort_order" name="sort_order" type="number" min="0"
                       value="{{ old('sort_order', $isEdit ? $pimpinan->sort_order : 0) }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>
            <label class="mt-6 flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $isEdit ? $pimpinan->is_active : true))>
                Aktif
            </label>
        </div>

        <div class="flex items-center gap-3 pt-1">
            <button type="submit" class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
                {{ $isEdit ? 'Perbarui' : 'Simpan' }}
            </button>
            <a href="{{ route('admin.pimpinan-dewan.index') }}" class="text-sm text-slate-600 hover:underline">Kembali</a>
        </div>
    </form>
@endsection
