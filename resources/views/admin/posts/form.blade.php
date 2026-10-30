@extends('layouts.admin')

@php
    $isEdit = $post->exists;
    $selectedImage = old('featured_image', $post->featured_image);
@endphp

@section('title', $isEdit ? 'Ubah berita' : 'Berita baru')
@section('heading', $isEdit ? 'Ubah berita' : 'Berita baru')
@section('subheading', $isEdit ? '/berita/'.$post->slug : 'Tulis kabar atau pengumuman baru')

@section('content')
    <form method="POST"
          action="{{ $isEdit ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
          class="grid gap-6 lg:grid-cols-[1.6fr_1fr]">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="space-y-5 rounded-2xl border border-slate-200 bg-white p-5">
            <div>
                <label for="title" class="block text-xs font-medium text-slate-600">Judul <span class="text-red-500">*</span></label>
                <input id="title" name="title" type="text" required value="{{ old('title', $post->title) }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>

            <div>
                <label for="slug" class="block text-xs font-medium text-slate-600">Slug</label>
                <div class="mt-1 flex items-center rounded-lg border border-slate-300 px-3">
                    <span class="text-xs text-slate-400">/berita/</span>
                    <input id="slug" name="slug" type="text" value="{{ old('slug', $post->slug) }}"
                           placeholder="otomatis-dari-judul"
                           class="w-full border-0 px-1 py-2 text-sm focus:outline-none focus:ring-0">
                </div>
            </div>

            <div>
                <label for="excerpt" class="block text-xs font-medium text-slate-600">Ringkasan</label>
                <textarea id="excerpt" name="excerpt" rows="2" maxlength="500"
                          class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('excerpt', $post->excerpt) }}</textarea>
            </div>

            <div>
                <label for="body" class="block text-xs font-medium text-slate-600">Isi berita</label>
                <textarea id="body" name="body" data-rich-editor rows="14" placeholder="Tulis isi berita…"
                          class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('body', $post->body) }}</textarea>
            </div>
        </div>

        <div class="space-y-5">
            <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5">
                <div>
                    <label for="status" class="block text-xs font-medium text-slate-600">Status</label>
                    <select id="status" name="status" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        <option value="draft" @selected(old('status', $post->status) === 'draft')>Draf</option>
                        <option value="published" @selected(old('status', $post->status) === 'published')>Terbit</option>
                    </select>
                </div>

                <div>
                    <label for="post_category_id" class="block text-xs font-medium text-slate-600">Kategori</label>
                    <select id="post_category_id" name="post_category_id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        <option value="">Tanpa kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) old('post_category_id', $post->post_category_id) === (string) $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="published_at" class="block text-xs font-medium text-slate-600">Tanggal terbit</label>
                    <input id="published_at" name="published_at" type="datetime-local"
                           value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <p class="mt-1 text-xs text-slate-400">Kosongkan untuk otomatis saat diterbitkan.</p>
                </div>

                <div>
                    <p class="text-xs font-medium text-slate-600">Gambar utama</p>
                    <div class="mt-2" data-media-picker>
                        <input type="hidden" name="featured_image" data-media-input value="{{ $selectedImage }}">

                        <div class="flex items-start gap-3">
                            <div class="flex h-24 w-32 items-center justify-center overflow-hidden rounded-lg border border-slate-200 bg-slate-50">
                                <img data-media-preview src="{{ $selectedImage ? asset($selectedImage) : '' }}"
                                     alt="" @class(['h-full w-full object-cover', 'hidden' => ! $selectedImage])>
                                <span data-media-placeholder @class(['text-xs text-slate-400', 'hidden' => (bool) $selectedImage])>
                                    Belum ada
                                </span>
                            </div>

                            <div class="space-y-2">
                                <button type="button" data-media-button
                                        class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                    Unggah gambar
                                </button>
                                <button type="button" data-media-clear
                                        @class(['rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50', 'hidden' => ! $selectedImage])>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">SEO</p>

                <div>
                    <label for="meta_title" class="block text-xs font-medium text-slate-600">Meta title</label>
                    <input id="meta_title" name="meta_title" type="text" maxlength="160"
                           value="{{ old('meta_title', $post->meta_title) }}"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>

                <div>
                    <label for="meta_description" class="block text-xs font-medium text-slate-600">Meta description</label>
                    <textarea id="meta_description" name="meta_description" rows="3" maxlength="320"
                              class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('meta_description', $post->meta_description) }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('admin.posts.index') }}" class="text-sm text-slate-600 hover:text-slate-900">Batal</a>
                <button type="submit" class="rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-800">
                    {{ $isEdit ? 'Simpan perubahan' : 'Simpan berita' }}
                </button>
            </div>
        </div>
    </form>
@endsection
