@extends('layouts.admin')

@section('title', 'Distribusi Dana')
@section('heading', 'Distribusi Dana')
@section('subheading', 'Kelola semua data distribusi dana: triwulan, komponen, alokasi, mahasiswa, dan info')

@section('content')
    <form method="POST" action="{{ route('admin.distribusi-dana.update') }}"
          class="space-y-6">
        @csrf
        @method('PUT')

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-semibold text-slate-900 mb-4">1. Periode &amp; Triwulan</h2>
            <div class="grid gap-3 sm:grid-cols-3">
                <div>
                    <label for="periode_id" class="block text-xs font-medium text-slate-600">Periode <span class="text-red-500">*</span></label>
                    <select id="periode_id" name="periode_id" required
                            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        @foreach (\App\Models\Period::query()->get() as $period)
                            <option value="{{ $period->id }}" @selected(old('periode_id', $periode?->id ?? ($periode?->firstWhere('is_active', true)?->id ?? null)) === $period->id)>
                                {{ $period->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="triwulan" class="block text-xs font-medium text-slate-600">Triwulan <span class="text-red-500">*</span></label>
                    <select id="triwulan" name="triwulan" required
                            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        @for ($i = 1; $i <= 4; $i++)
                            <option value="{{ $i }}" @selected(old('triwulan', $triwulan?->triwulan ?? 1) === $i)>Triwulan {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label for="total_dana" class="block text-xs font-medium text-slate-600">Total Dana (Rp) <span class="text-red-500">*</span></label>
                    <input id="total_dana" name="total_dana" type="number" min="0" required
                           value="{{ old('total_dana', $totalDana ?? $triwulan?->total_dana ?? 0) }}"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label for="status" class="block text-xs font-medium text-slate-600">Status</label>
                    <select id="status" name="status"
                            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        <option value="draft" @selected(old('status', $triwulan?->status ?? 'terbit') === 'draft')>Draft</option>
                        <option value="terbit" @selected(old('status', $triwulan?->status ?? 'terbit') === 'terbit')>Terbit</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-semibold text-slate-900 mb-4">2. Komponen Dana</h2>
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-2">Komponen</th>
                            <th class="px-4 py-2 text-right">Peran</th>
                            <th class="px-4 py-2 text-right">Jumlah (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php $komponenMap = $komponen->keyBy('id'); @endphp
                        @foreach ($komponen as $k)
                            @php $dk = $k->danaKomponen()->where('dana_triwulan_id', $triwulan?->id)->first(); @endphp
                            <tr>
                                <td class="px-4 py-3">
                                    <input type="hidden" name="komponen[{{ $k->id }}][id]" value="{{ $k->id }}">
                                    <span class="font-medium text-slate-900">{{ $k->nama }}</span>
                                    <p class="text-xs text-slate-500">{{ $k->kode }}</p>
                                </td>
                                <td class="px-4 py-3 text-right text-slate-600">{{ $k->peran }}</td>
                                <td class="px-4 py-3 text-right">
                                    <input name="komponen[{{ $k->id }}][jumlah]" type="number" min="0"
                                           value="{{ old('komponen.'.$k->id.'.jumlah', $dk?->jumlah ?? 0) }}"
                                           class="w-full rounded-lg border border-slate-300 px-2 py-1 text-sm text-right">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-semibold text-slate-900 mb-4">3. Alokasi Distribusi (per Lembaga)</h2>
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-2">Lembaga</th>
                            <th class="px-4 py-2 text-right">Tingkat</th>
                            <th class="px-4 py-2 text-right">Jumlah (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php $adMap = []; @endphp
                        @foreach ($alokasiDistribusi as $ad)
                            @php $adMap[$ad->lembaga_id] = $ad->jumlah; @endphp
                        @endforeach
                        @foreach (\App\Models\Lembaga::query()->orderBy('tingkat')->orderBy('nama')->get() as $l)
                            <tr>
                                <td class="px-4 py-3">
                                    <input type="hidden" name="alokasi_distribusi[{{ $l->id }}][lembaga_id]" value="{{ $l->id }}">
                                    <span class="font-medium text-slate-900">{{ $l->nama }}</span>
                                    <p class="text-xs text-slate-500">{{ ucfirst($l->jenis ?? '') }}</p>
                                </td>
                                <td class="px-4 py-3 text-right text-slate-600">{{ $l->tingkat }}</td>
                                <td class="px-4 py-3 text-right">
                                    <input name="alokasi_distribusi[{{ $l->id }}][jumlah]" type="number" min="0"
                                           value="{{ old('alokasi_distribusi.'.$l->id.'.jumlah', $adMap[$l->id] ?? 0) }}"
                                           class="w-full rounded-lg border border-slate-300 px-2 py-1 text-sm text-right">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-semibold text-slate-900 mb-4">4. Alokasi Taktis (per Fakultas)</h2>
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-2">Fakultas</th>
                            <th class="px-4 py-2 text-right">Jumlah (Rp)</th>
                            <th class="px-4 py-2">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php $atMap = []; @endphp
                        @foreach ($alokasiTaktis as $at)
                            @php $atMap[$at->fakultas_id ?? 'universitas'] = $at; @endphp
                        @endforeach
                        @foreach (\App\Models\Fakultas::query()->orderBy('nama')->get() as $f)
                            @php $t = $atMap[$f->id] ?? null; @endphp
                            <tr>
                                <td class="px-4 py-3">
                                    <input type="hidden" name="alokasi_taktis[{{ $loop->index }}][fakultas_id]" value="{{ $f->id }}">
                                    <span class="font-medium text-slate-900">{{ $f->nama }}</span>
                                    <p class="text-xs text-slate-500">{{ $f->kode }}</p>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <input name="alokasi_taktis[{{ $loop->index }}][jumlah]" type="number" min="0"
                                           value="{{ old('alokasi_taktis.'.$loop->index.'.jumlah', $t?->jumlah ?? 0) }}"
                                           class="w-full rounded-lg border border-slate-300 px-2 py-1 text-sm text-right">
                                </td>
                                <td class="px-4 py-3">
                                    <input name="alokasi_taktis[{{ $loop->index }}][keterangan]" type="text"
                                           value="{{ old('alokasi_taktis.'.$loop->index.'.keterangan', $t?->keterangan ?? '') }}"
                                           placeholder="Keterangan (opsional)"
                                           class="w-full rounded-lg border border-slate-300 px-2 py-1 text-sm">
                                </td>
                            </tr>
                        @endforeach
                        @php $universitasTaktis = $atMap['universitas'] ?? null; @endphp
                        <tr>
                            <td class="px-4 py-3">
                                <input type="hidden" name="alokasi_taktis[universitas][fakultas_id]" value="">
                                <span class="font-medium text-slate-900">Universitas</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <input name="alokasi_taktis[universitas][jumlah]" type="number" min="0"
                                       value="{{ old('alokasi_taktis.universitas.jumlah', $universitasTaktis?->jumlah ?? 0) }}"
                                       class="w-full rounded-lg border border-slate-300 px-2 py-1 text-sm text-right">
                            </td>
                            <td class="px-4 py-3">
                                <input name="alokasi_taktis[universitas][keterangan]" type="text"
                                       value="{{ old('alokasi_taktis.universitas.keterangan', $universitasTaktis?->keterangan ?? '') }}"
                                       placeholder="Keterangan (opsional)"
                                       class="w-full rounded-lg border border-slate-300 px-2 py-1 text-sm">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-semibold text-slate-900 mb-4">5. Mahasiswa per Fakultas</h2>
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-2">Fakultas</th>
                            <th class="px-4 py-2 text-right">Jumlah Mahasiswa</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php $mhsMap = []; @endphp
                        @foreach ($mahasiswa as $m)
                            @php $mhsMap[$m->fakultas_id] = $m->jumlah_mahasiswa; @endphp
                        @endforeach
                        @foreach (\App\Models\Fakultas::query()->orderBy('nama')->get() as $f)
                            <tr>
                                <td class="px-4 py-3">
                                    <input type="hidden" name="mahasiswa[{{ $loop->index }}][fakultas_id]" value="{{ $f->id }}">
                                    <span class="font-medium text-slate-900">{{ $f->nama }}</span>
                                    <p class="text-xs text-slate-500">{{ $f->kode }}</p>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <input name="mahasiswa[{{ $loop->index }}][jumlah_mahasiswa]" type="number" min="0"
                                           value="{{ old('mahasiswa.'.$loop->index.'.jumlah_mahasiswa', $mhsMap[$f->id] ?? 0) }}"
                                           class="w-full rounded-lg border border-slate-300 px-2 py-1 text-sm text-right">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-semibold text-slate-900 mb-4">6. Dana Info &amp; Seksi</h2>

            <div class="grid gap-4 lg:grid-cols-2">
                <div class="rounded-xl border border-slate-200 bg-white p-4">
                    <h3 class="text-xs font-semibold text-slate-600 mb-3 uppercase tracking-wide">Info Teks per Seksi</h3>
                    <div class="space-y-3">
                        @php $sections = [
                            'overview' => 'Ringkasan',
                            'pembagian' => 'Pembagian Komponen',
                            'universitas' => 'Tingkat Universitas',
                            'fakultas' => 'Tingkat Fakultas',
                            'per_fakultas' => 'Per Fakultas',
                            'rasio' => 'Rasio Mahasiswa',
                            'taktis' => 'Dana Taktis',
                        ]; @endphp
                        @foreach ($sections as $seksi => $label)
                            <div>
                                <label class="block text-xs font-medium text-slate-600">{{ $label }}</label>
                                <input name="dana_info[{{ $loop->index }}][seksi]" type="hidden" value="{{ $seksi }}">
                                <textarea name="dana_info[{{ $loop->index }}][teks]" rows="2"
                                          class="w-full rounded-lg border border-slate-300 px-2 py-1 text-sm">
{{ old('dana_info.'.$loop->index.'.teks', $danaInfo[$seksi] ?? '') }}</textarea>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-4">
                    <h3 class="text-xs font-semibold text-slate-600 mb-3 uppercase tracking-wide">Seksi Tampilan</h3>
                    <div class="space-y-3">
                        @foreach ($sections as $seksi => $label)
                            @php $ds = $danaSeksi->firstWhere('seksi', $seksi); @endphp
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-700">{{ $label }}</span>
                                <div class="flex items-center gap-2">
                                    <input type="hidden" name="dana_seksi[{{ $loop->index }}][seksi]" value="{{ $seksi }}">
                                    <input name="dana_seksi[{{ $loop->index }}][judul]" type="text"
                                           value="{{ old('dana_seksi.'.$loop->index.'.judul', $ds?->judul ?? ucfirst($seksi)) }}"
                                           class="rounded-lg border border-slate-300 px-2 py-1 text-sm w-32">
                                    <input name="dana_seksi[{{ $loop->index }}][urutan]" type="number" min="0"
                                           value="{{ old('dana_seksi.'.$loop->index.'.urutan', $ds?->urutan ?? $loop->index) }}"
                                           class="rounded-lg border border-slate-300 px-2 py-1 text-sm w-16">
                                    <label class="flex items-center gap-1 text-xs text-slate-700">
                                        <input type="checkbox" name="dana_seksi[{{ $loop->index }}][is_tampil]" value="1"
                                               @checked(old('dana_seksi.'.$loop->index.'.is_tampil', $ds?->is_tampil ?? true))>
                                        Tampil
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="w-full rounded-lg bg-[#0B3C8D] px-5 py-3 text-sm font-semibold text-white hover:bg-[#08285C]">
            Simpan Semua Data Distribusi Dana
        </button>
    </form>

    @if (session('success'))
        <div class="mt-4 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
    @endif
@endsection
