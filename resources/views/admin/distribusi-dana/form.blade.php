@extends('layouts.admin')

@section('title', $triwulan ? 'Edit Triwulan ' . $triwulan->triwulan : 'Tambah Triwulan Baru')
@section('heading', $triwulan ? 'Edit Triwulan' : 'Tambah Triwulan Baru')
@section('subheading', $triwulan ? 'Periode ' . $triwulan->periode->name . ' · Triwulan ' . $triwulan->triwulan : 'Buat data distribusi dana triwulan baru')

@section('content')
<form method="POST"
      action="{{ $triwulan ? route('admin.distribusi-dana.update', $triwulan) : route('admin.distribusi-dana.store') }}"
      class="space-y-6">
    @csrf
    @if ($triwulan)
        @method('PUT')
    @endif

    {{-- 1. Periode & Triwulan --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <h2 class="text-sm font-semibold text-slate-900 mb-4">1. Periode & Triwulan</h2>
        <div class="grid gap-3 sm:grid-cols-4">
            <div>
                <label for="periode_id" class="block text-xs font-medium text-slate-600">Periode <span class="text-red-500">*</span></label>
                <select id="periode_id" name="periode_id" required
                        class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}" @selected(old('periode_id', $triwulan->periode_id ?? $period->id) == $period->id)>
                            {{ $period->name }}
                        </option>
                    @endforeach
                </select>
                @error('periode_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="triwulan" class="block text-xs font-medium text-slate-600">Triwulan <span class="text-red-500">*</span></label>
                <select id="triwulan" name="triwulan" required
                        class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option value="">Pilih</option>
                    @for ($i = 1; $i <= 4; $i++)
                        <option value="{{ $i }}" @selected(old('triwulan', $triwulan->triwulan ?? '') == $i)>Triwulan {{ $i }}</option>
                    @endfor
                </select>
                @error('triwulan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="total_dana" class="block text-xs font-medium text-slate-600">Total Dana (Rp) <span class="text-red-500">*</span></label>
                <input id="total_dana" name="total_dana" type="number" step="1000" min="0" required
                       value="{{ old('total_dana', $triwulan->total_dana ?? '') }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                @error('total_dana') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="status" class="block text-xs font-medium text-slate-600">Status <span class="text-red-500">*</span></label>
                <select id="status" name="status" required
                        class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option value="draft" @selected(old('status', $triwulan->status ?? 'draft') === 'draft')>Draft</option>
                    <option value="terbit" @selected(old('status', $triwulan->status ?? '') === 'terbit')>Terbit</option>
                </select>
                @error('status') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- 2. Komponen Dana --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <h2 class="text-sm font-semibold text-slate-900 mb-4">2. Komponen Dana</h2>
        <p class="text-xs text-slate-500 mb-3">Isi jumlah untuk setiap komponen yang ditampilkan.</p>
        <div class="space-y-3">
            @foreach ($komponen as $k)
                <div class="grid gap-3 sm:grid-cols-[1fr_120px]">
                    <input type="hidden" name="komponen[{{ $k->id }}][id]" value="{{ $k->id }}">
                    <label class="flex items-center gap-2 text-sm text-slate-700">
                        <span class="font-medium">{{ $k->nama }} ({{ $k->peran }})</span>
                        @if ($k->satuan)
                            <span class="text-xs text-slate-400">({{ $k->satuan }})</span>
                        @endif
                    </label>
                    <input type="number" name="komponen[{{ $k->id }}][jumlah]" step="1000" min="0"
                           value="{{ old('komponen.' . $k->id . '.jumlah', $existingData['komponen'][$k->id] ?? '') }}"
                           class="rounded-lg border border-slate-300 px-3 py-2 text-sm text-right font-mono"
                           placeholder="0">
                </div>
            @endforeach
        </div>
    </div>

    {{-- 3. Alokasi Distribusi (per Lembaga) --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <h2 class="text-sm font-semibold text-slate-900 mb-4">3. Alokasi Distribusi (per Lembaga)</h2>
        <div class="space-y-3 max-h-96 overflow-y-auto">
            @foreach ($lembaga as $l)
                <div class="grid gap-3 sm:grid-cols-[1fr_140px]">
                    <input type="hidden" name="alokasi_distribusi[{{ $l->id }}][lembaga_id]" value="{{ $l->id }}">
                    <label class="flex items-center gap-2 text-sm text-slate-700">
                        <span class="font-medium">{{ $l->short_name }}</span>
                        <span class="text-xs text-slate-400">{{ $l->tingkat === 'universitas' ? 'Universitas' : 'Fakultas ' . ($l->fakultas->kode ?? '') }}</span>
                    </label>
                    <input type="number" name="alokasi_distribusi[{{ $l->id }}][jumlah]" step="1000" min="0"
                           value="{{ old('alokasi_distribusi.' . $l->id . '.jumlah', $existingData['alokasi_distribusi'][$l->id] ?? '') }}"
                           class="rounded-lg border border-slate-300 px-3 py-2 text-sm text-right font-mono"
                           placeholder="0">
                </div>
            @endforeach
        </div>
    </div>

    {{-- 4. Alokasi Taktis (per Fakultas + Universitas) --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <h2 class="text-sm font-semibold text-slate-900 mb-4">4. Alokasi Taktis (per Fakultas + Universitas)</h2>
        <p class="text-xs text-slate-500 mb-3">Kosongkan fakultas untuk alokasi tingkat Universitas. Isi keterangan jika perlu.</p>
        <div class="space-y-3 max-h-96 overflow-y-auto">
            {{-- Universitas (fakultas_id = null) --}}
            <div class="grid gap-3 sm:grid-cols-[1fr_140px_200px] border-b border-slate-200 pb-3">
                <input type="hidden" name="alokasi_taktis[universitas][fakultas_id]" value="">
                <label class="flex items-center gap-2 text-sm text-slate-700 font-semibold">
                    <span>Universitas (Tingkat Pusat)</span>
                </label>
                <input type="number" name="alokasi_taktis[universitas][jumlah]" step="1000" min="0"
                       value="{{ old('alokasi_taktis.universitas.jumlah', $existingData['alokasi_taktis']['universitas']['jumlah'] ?? '') }}"
                       class="rounded-lg border border-slate-300 px-3 py-2 text-sm text-right font-mono"
                       placeholder="0">
                <input type="text" name="alokasi_taktis[universitas][keterangan]"
                       value="{{ old('alokasi_taktis.universitas.keterangan', $existingData['alokasi_taktis']['universitas']['keterangan'] ?? '') }}"
                       class="rounded-lg border border-slate-300 px-3 py-2 text-sm"
                       placeholder="Keterangan (opsional)">
            </div>

            {{-- Per Fakultas --}}
            @foreach ($fakultas as $f)
                <div class="grid gap-3 sm:grid-cols-[1fr_140px_200px]">
                    <input type="hidden" name="alokasi_taktis[{{ $f->id }}][fakultas_id]" value="{{ $f->id }}">
                    <label class="flex items-center gap-2 text-sm text-slate-700">
                        <span class="font-medium">{{ $f->kode }}</span>
                        <span class="text-xs text-slate-400">{{ $f->nama }}</span>
                    </label>
                    <input type="number" name="alokasi_taktis[{{ $f->id }}][jumlah]" step="1000" min="0"
                           value="{{ old('alokasi_taktis.' . $f->id . '.jumlah', $existingData['alokasi_taktis'][$f->id]['jumlah'] ?? '') }}"
                           class="rounded-lg border border-slate-300 px-3 py-2 text-sm text-right font-mono"
                           placeholder="0">
                    <input type="text" name="alokasi_taktis[{{ $f->id }}][keterangan]"
                           value="{{ old('alokasi_taktis.' . $f->id . '.keterangan', $existingData['alokasi_taktis'][$f->id]['keterangan'] ?? '') }}"
                           class="rounded-lg border border-slate-300 px-3 py-2 text-sm"
                           placeholder="Keterangan (opsional)">
                </div>
            @endforeach
        </div>
    </div>

    {{-- 5. Mahasiswa per Fakultas --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <h2 class="text-sm font-semibold text-slate-900 mb-4">5. Mahasiswa per Fakultas</h2>
        <p class="text-xs text-slate-500 mb-3">Data ini bersifat per periode (bukan per triwulan).</p>
        <div class="grid gap-3 sm:grid-cols-4">
            @foreach ($fakultas as $f)
                <div class="sm:col-span-1">
                    <input type="hidden" name="mahasiswa[{{ $f->id }}][fakultas_id]" value="{{ $f->id }}">
                    <label class="block text-xs font-medium text-slate-600">{{ $f->kode }}</label>
                    <input type="number" name="mahasiswa[{{ $f->id }}][jumlah_mahasiswa]" min="0"
                           value="{{ old('mahasiswa.' . $f->id . '.jumlah_mahasiswa', $existingData['mahasiswa'][$f->id] ?? '') }}"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-right font-mono"
                           placeholder="0">
                </div>
            @endforeach
        </div>
    </div>

    {{-- 6. Dana Info (teks per seksi) --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <h2 class="text-sm font-semibold text-slate-900 mb-4">6. Dana Info (Teks per Seksi)</h2>
        <div class="space-y-3">
            @php
                $infoSeksi = ['penerimaan', 'pengeluaran', 'sisa', 'catatan'];
            @endphp
            @foreach ($infoSeksi as $seksi)
                <div class="sm:col-span-1">
                    <input type="hidden" name="dana_info[{{ $loop->index }}][seksi]" value="{{ $seksi }}">
                    <label class="block text-xs font-medium text-slate-600">{{ ucfirst($seksi) }}</label>
                    <textarea name="dana_info[{{ $loop->index }}][teks]" rows="3"
                              class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"
                              placeholder="Tulis {{ $seksi }}...">{{ old('dana_info.' . $loop->index . '.teks', $existingData['dana_info'][$seksi] ?? '') }}</textarea>
                </div>
            @endforeach
        </div>
    </div>

    {{-- 7. Dana Seksi (tampilkan/tidak) --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <h2 class="text-sm font-semibold text-slate-900 mb-4">7. Dana Seksi (Tampil / Sembunyikan)</h2>
        <div class="space-y-3">
            @foreach (['ringkasan', 'komponen', 'alokasi', 'taktis', 'mahasiswa', 'aset'] as $idx => $seksi)
                <div class="flex items-center gap-3 sm:grid-cols-[auto_1fr_auto_80px_100px]">
                    <input type="hidden" name="dana_seksi[{{ $idx }}][seksi]" value="{{ $seksi }}">
                    <label class="w-32 text-sm text-slate-700">{{ ucfirst($seksi) }}</label>
                    <input type="text" name="dana_seksi[{{ $idx }}][judul]"
                           value="{{ old('dana_seksi.' . $idx . '.judul', $existingData['dana_seksi'][$seksi]['judul'] ?? ucfirst($seksi)) }}"
                           class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm"
                           placeholder="Judul">
                    <input type="number" name="dana_seksi[{{ $idx }}][urutan]" min="0"
                           value="{{ old('dana_seksi.' . $idx . '.urutan', $existingData['dana_seksi'][$seksi]['urutan'] ?? ($idx + 1) * 10) }}"
                           class="w-20 rounded-lg border border-slate-300 px-3 py-2 text-sm text-center"
                           placeholder="Urutan">
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="dana_seksi[{{ $idx }}][is_tampil]" value="1"
                               @checked(old('dana_seksi.' . $idx . '.is_tampil', $existingData['dana_seksi'][$seksi]['is_tampil'] ?? true))>
                        Tampil
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-3 pt-4 border-t border-slate-200">
        <a href="{{ route('admin.distribusi-dana.index') }}" class="text-sm text-slate-600 hover:underline">Kembali ke riwayat</a>
        @if ($triwulan)
            <a href="{{ route('dana.distribusi') }}" target="_blank" rel="noopener" class="text-sm text-[#0B3C8D] hover:underline">Lihat halaman publik</a>
        @endif
        <button type="submit" class="ml-auto rounded-lg bg-[#0B3C8D] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#08285C]">
            {{ $triwulan ? 'Simpan Perubahan' : 'Buat Triwulan' }}
        </button>
    </div>
</form>
@endsection