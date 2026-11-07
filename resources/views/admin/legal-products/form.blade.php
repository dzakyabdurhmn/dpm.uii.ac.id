@extends('layouts.admin')

@php
    $isEdit = $product->exists;
@endphp

@section('title', $isEdit ? 'Ubah produk hukum' : 'Produk hukum baru')
@section('heading', $isEdit ? 'Ubah produk hukum' : 'Produk hukum baru')
@section('subheading', 'Nomor dan tahun hanya dipakai untuk PKM/PDPM')

@section('content')
    <form method="POST"
          action="{{ $isEdit ? route('admin.legal-products.update', $product) : route('admin.legal-products.store') }}"
          enctype="multipart/form-data"
          class="grid gap-6 lg:grid-cols-[1.6fr_1fr]">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="space-y-5 rounded-2xl border border-slate-200 bg-white p-5">
            <div>
                <label for="type" class="block text-xs font-medium text-slate-600">Jenis <span class="text-red-500">*</span></label>
                <select id="type" name="type" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    @foreach ($types as $key => $meta)
                        <option value="{{ $key }}" @selected(old('type', $product->type) === $key)>
                            {{ $meta['label'] }} — {{ $meta['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label for="edition" class="block text-xs font-medium text-slate-600">Edisi</label>
                    <input id="edition" name="edition" type="text"
                           value="{{ old('edition', $product->edition) }}"
                           placeholder="Contoh: Ke-38 (1)"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <p class="mt-1 text-xs text-slate-400">Terutama untuk PDKM/GBHKM.</p>
                </div>

                <div>
                    <label for="number" class="block text-xs font-medium text-slate-600">Nomor</label>
                    <input id="number" name="number" type="number" min="1" max="999"
                           value="{{ old('number', $product->number) }}"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <p class="mt-1 text-xs text-slate-400">Wajib untuk PKM/PDPM.</p>
                </div>

                <div>
                    <label for="year" class="block text-xs font-medium text-slate-600">Tahun</label>
                    <input id="year" name="year" type="number" min="1945" max="2100"
                           value="{{ old('year', $product->year) }}"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <p class="mt-1 text-xs text-slate-400">Tahun pengesahan.</p>
                </div>
            </div>

            <div>
                <label for="title" class="block text-xs font-medium text-slate-600">
                    Pokok peraturan <span class="text-red-500">*</span>
                </label>
                <input id="title" name="title" type="text" required value="{{ old('title', $product->title) }}"
                       placeholder="Tentang Pemilihan Umum Wakil Mahasiswa UII"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                <p class="mt-1 text-xs text-slate-400">Tanpa kata "Tentang" berlebihan — nomor &amp; jenis sudah ditampilkan otomatis.</p>
            </div>

            <div>
                <label for="slug" class="block text-xs font-medium text-slate-600">Slug</label>
                <input id="slug" name="slug" type="text" value="{{ old('slug', $product->slug) }}"
                       placeholder="otomatis"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>

            <div>
                <label for="description" class="block text-xs font-medium text-slate-600">Ringkasan</label>
                <textarea id="description" name="description" rows="3"
                          class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Berkas</p>

                @if ($isEdit && $product->file_path)
                    <p class="mt-2 text-xs text-slate-600">
                        Berkas saat ini:
                        <a href="{{ asset($product->file_path) }}" target="_blank" rel="noopener"
                           class="font-medium text-brand-700 hover:underline">{{ basename($product->file_path) }}</a>
                    </p>
                @endif

                <label for="file" class="mt-3 block text-xs font-medium text-slate-600">
                    Berkas produk hukum (wajib, PDF/DOC, maks 20 MB)
                </label>
                <input id="file" name="file" type="file" accept=".pdf,.doc,.docx"
                       class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                <p class="mt-1 text-xs text-slate-500">
                    Dokumen disimpan di server (public/uploads). Tautan eksternal tidak diperbolehkan.
                </p>
            </div>
        </div>

        <div class="space-y-5">
            <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5">
                <div>
                    <label for="amends_id" class="block text-xs font-medium text-slate-600">
                        Perubahan atas (opsional)
                    </label>
                    <select id="amends_id" name="amends_id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        <option value="">Bukan perubahan</option>
                        @foreach ($amendableOptions as $option)
                            <option value="{{ $option->id }}" @selected((string) old('amends_id', $product->amends_id) === (string) $option->id)>
                                {{ $option->heading }} — {{ \Illuminate\Support\Str::limit($option->title, 40) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="period_id" class="block text-xs font-medium text-slate-600">Periode kepengurusan</label>
                    <select id="period_id" name="period_id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        <option value="">Tidak terkait periode</option>
                        @foreach ($periods as $period)
                            <option value="{{ $period->id }}" @selected((string) old('period_id', $product->period_id) === (string) $period->id)>
                                {{ $period->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="published_at" class="block text-xs font-medium text-slate-600">Tanggal penetapan</label>
                    <input id="published_at" name="published_at" type="datetime-local"
                           value="{{ old('published_at', $product->published_at?->format('Y-m-d\TH:i')) }}"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>

                <div>
                    <label for="status" class="block text-xs font-medium text-slate-600">Status Keberlakuan</label>
                    <select id="status" name="status" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        <option value="aktif" @selected(old('status', $product->status ?? 'aktif') === 'aktif')>Aktif / Berlaku</option>
                        <option value="tidak_aktif" @selected(old('status', $product->status ?? 'aktif') === 'tidak_aktif')>Tidak Aktif / Dicabut / Tidak Berlaku</option>
                    </select>
                </div>

                <div>
                    <label for="sort_order" class="block text-xs font-medium text-slate-600">Urutan</label>
                    <input id="sort_order" name="sort_order" type="number" min="0"
                           value="{{ old('sort_order', $product->sort_order ?? 0) }}"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>

                <label class="flex items-start gap-2 text-xs text-slate-600">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $product->is_published ?? true))
                           class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-600">
                    <span>Tampilkan di halaman produk hukum</span>
                </label>
            </div>

            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('admin.legal-products.index') }}" class="text-sm text-slate-600 hover:text-slate-900">Batal</a>
                <button type="submit" class="rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-800">
                    {{ $isEdit ? 'Simpan perubahan' : 'Simpan produk hukum' }}
                </button>
            </div>
        </div>
    </form>
@endsection
