@extends('layouts.admin')

@php
    $isEdit = $document->exists;
@endphp

@section('title', $isEdit ? 'Ubah dokumen' : 'Dokumen baru')
@section('heading', $isEdit ? 'Ubah dokumen' : 'Dokumen baru')
@section('subheading', 'Unggah berkas atau tautkan dokumen eksternal')

@section('content')
    <form method="POST"
          action="{{ $isEdit ? route('admin.documents.update', $document) : route('admin.documents.store') }}"
          enctype="multipart/form-data"
          class="grid gap-6 lg:grid-cols-[1.6fr_1fr]">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="space-y-5 rounded-2xl border border-slate-200 bg-white p-5">
            <div>
                <label for="title" class="block text-xs font-medium text-slate-600">Judul <span class="text-red-500">*</span></label>
                <input id="title" name="title" type="text" required value="{{ old('title', $document->title) }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>

            <div>
                <label for="slug" class="block text-xs font-medium text-slate-600">Slug</label>
                <input id="slug" name="slug" type="text" value="{{ old('slug', $document->slug) }}"
                       placeholder="otomatis-dari-judul"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>

            <div>
                <label for="description" class="block text-xs font-medium text-slate-600">Deskripsi</label>
                <textarea id="description" name="description" rows="3" maxlength="2000"
                          class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('description', $document->description) }}</textarea>
            </div>

            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Berkas</p>

                @if ($isEdit && $document->file_path)
                    <p class="mt-2 text-xs text-slate-600">
                        Berkas saat ini:
                        <a href="{{ asset($document->file_path) }}" target="_blank" rel="noopener" class="font-medium text-brand-700 hover:underline">
                            {{ basename($document->file_path) }}
                        </a>
                    </p>
                @endif

                <label for="file" class="mt-3 block text-xs font-medium text-slate-600">
                    Unggah berkas (PDF, DOC, XLS, PPT, ZIP, gambar — maks 20 MB)
                </label>
                <input id="file" name="file" type="file"
                       accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.jpg,.jpeg,.png"
                       class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">

                <label for="external_url" class="mt-3 block text-xs font-medium text-slate-600">
                    atau tautan eksternal (Google Drive, dsb.)
                </label>
                <input id="external_url" name="external_url" type="url" value="{{ old('external_url', $document->external_url) }}"
                       placeholder="https://drive.google.com/file/d/…"
                       class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">

                <p class="mt-2 text-xs text-slate-500">
                    Isi salah satu saja. Berkas unggahan disimpan di <code>public/uploads/documents</code>.
                </p>
            </div>
        </div>

        <div class="space-y-5">
            <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5">
                <div>
                    <label for="document_category_id" class="block text-xs font-medium text-slate-600">Kategori <span class="text-red-500">*</span></label>
                    <select id="document_category_id" name="document_category_id" required
                            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) old('document_category_id', $document->document_category_id) === (string) $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="year" class="block text-xs font-medium text-slate-600">Tahun</label>
                        <input id="year" name="year" type="number" min="2000" max="2100"
                               value="{{ old('year', $document->year) }}"
                               class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label for="quarter" class="block text-xs font-medium text-slate-600">Triwulan</label>
                        <select id="quarter" name="quarter" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                            <option value="">—</option>
                            @foreach (\App\Models\Document::QUARTERS as $value => $label)
                                <option value="{{ $value }}" @selected((string) old('quarter', $document->quarter) === (string) $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="period_id" class="block text-xs font-medium text-slate-600">Periode kepengurusan</label>
                    <select id="period_id" name="period_id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        <option value="">Tidak terkait periode</option>
                        @foreach ($periods as $period)
                            <option value="{{ $period->id }}" @selected((string) old('period_id', $document->period_id) === (string) $period->id)>
                                {{ $period->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="published_at" class="block text-xs font-medium text-slate-600">Tanggal terbit</label>
                    <input id="published_at" name="published_at" type="datetime-local"
                           value="{{ old('published_at', $document->published_at?->format('Y-m-d\TH:i')) }}"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <p class="mt-1 text-xs text-slate-400">Kosongkan untuk menyimpan sebagai draf.</p>
                </div>

                <div>
                    <label for="sort_order" class="block text-xs font-medium text-slate-600">Urutan</label>
                    <input id="sort_order" name="sort_order" type="number" min="0"
                           value="{{ old('sort_order', $document->sort_order ?? 0) }}"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>

                <label class="flex items-start gap-2 text-xs text-slate-600">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $document->is_featured))
                           class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-600">
                    <span>Tampilkan sebagai dokumen unggulan di beranda</span>
                </label>
            </div>

            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('admin.documents.index') }}" class="text-sm text-slate-600 hover:text-slate-900">Batal</a>
                <button type="submit" class="rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-800">
                    {{ $isEdit ? 'Simpan perubahan' : 'Simpan dokumen' }}
                </button>
            </div>
        </div>
    </form>
@endsection
