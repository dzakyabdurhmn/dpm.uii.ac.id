@extends('layouts.admin')

@php
    $value = fn (string $key) => old($key, $settings[$key] ?? '');
@endphp

@section('title', 'Pengaturan')
@section('heading', 'Pengaturan situs')
@section('subheading', 'Identitas, hero beranda, kontak, dan SEO')

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" class="grid gap-6 lg:grid-cols-2">
        @csrf
        @method('PUT')

        <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-semibold text-slate-900">Identitas situs</h2>

            <div>
                <label for="site_name" class="block text-xs font-medium text-slate-600">Nama situs <span class="text-red-500">*</span></label>
                <input id="site_name" name="site_name" type="text" required value="{{ $value('site_name') }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>

            <div>
                <label for="site_tagline" class="block text-xs font-medium text-slate-600">Tagline</label>
                <input id="site_tagline" name="site_tagline" type="text" value="{{ $value('site_tagline') }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>

            <div>
                <p class="text-xs font-medium text-slate-600">Logo</p>
                <div class="mt-2" data-media-picker>
                    <input type="hidden" name="site_logo" data-media-input value="{{ $value('site_logo') }}">

                    <div class="flex items-start gap-3">
                        <div class="flex h-20 w-20 items-center justify-center overflow-hidden rounded-lg border border-slate-200 bg-slate-50">
                            <img data-media-preview src="{{ $value('site_logo') ? asset($value('site_logo')) : '' }}"
                                 alt="" @class(['h-full w-full object-contain', 'hidden' => ! $value('site_logo')])>
                            <span data-media-placeholder @class(['text-xs text-slate-400', 'hidden' => (bool) $value('site_logo')])>
                                Belum ada
                            </span>
                        </div>

                        <div class="space-y-2">
                            <button type="button" data-media-button
                                    class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                Unggah logo
                            </button>
                            <button type="button" data-media-clear
                                    @class(['rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50', 'hidden' => ! $value('site_logo')])>
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label for="footer_text" class="block text-xs font-medium text-slate-600">Teks footer</label>
                <textarea id="footer_text" name="footer_text" rows="2"
                          class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ $value('footer_text') }}</textarea>
            </div>

            <div>
                <label for="about_text" class="block text-xs font-medium text-slate-600">Tentang singkat (beranda)</label>
                <textarea id="about_text" name="about_text" rows="4"
                          class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ $value('about_text') }}</textarea>
            </div>
        </div>

        <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-semibold text-slate-900">Hero beranda</h2>

            <div>
                <label for="hero_title" class="block text-xs font-medium text-slate-600">Judul hero</label>
                <input id="hero_title" name="hero_title" type="text" value="{{ $value('hero_title') }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>

            <div>
                <label for="hero_subtitle" class="block text-xs font-medium text-slate-600">Subjudul hero</label>
                <textarea id="hero_subtitle" name="hero_subtitle" rows="3"
                          class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ $value('hero_subtitle') }}</textarea>
            </div>

            <div>
                <p class="text-xs font-medium text-slate-600">Gambar hero (opsional)</p>
                <div class="mt-2" data-media-picker>
                    <input type="hidden" name="hero_image" data-media-input value="{{ $value('hero_image') }}">

                    <div class="flex items-start gap-3">
                        <div class="flex h-24 w-36 items-center justify-center overflow-hidden rounded-lg border border-slate-200 bg-slate-50">
                            <img data-media-preview src="{{ $value('hero_image') ? asset($value('hero_image')) : '' }}"
                                 alt="" @class(['h-full w-full object-cover', 'hidden' => ! $value('hero_image')])>
                            <span data-media-placeholder @class(['text-xs text-slate-400', 'hidden' => (bool) $value('hero_image')])>
                                Belum ada
                            </span>
                        </div>

                        <div class="space-y-2">
                            <button type="button" data-media-button
                                    class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                Unggah gambar
                            </button>
                            <button type="button" data-media-clear
                                    @class(['rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50', 'hidden' => ! $value('hero_image')])>
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-semibold text-slate-900">Kontak</h2>

            <div>
                <label for="contact_email" class="block text-xs font-medium text-slate-600">Email</label>
                <input id="contact_email" name="contact_email" type="email" value="{{ $value('contact_email') }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>

            <div>
                <label for="contact_phone" class="block text-xs font-medium text-slate-600">Telepon</label>
                <input id="contact_phone" name="contact_phone" type="text" value="{{ $value('contact_phone') }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>

            <div>
                <label for="contact_address" class="block text-xs font-medium text-slate-600">Alamat</label>
                <textarea id="contact_address" name="contact_address" rows="2"
                          class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ $value('contact_address') }}</textarea>
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label for="social_instagram" class="block text-xs font-medium text-slate-600">Instagram</label>
                    <input id="social_instagram" name="social_instagram" type="url" value="{{ $value('social_instagram') }}"
                           placeholder="https://instagram.com/dpmuii"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label for="social_linkedin" class="block text-xs font-medium text-slate-600">LinkedIn</label>
                    <input id="social_linkedin" name="social_linkedin" type="url" value="{{ $value('social_linkedin') }}"
                           placeholder="https://linkedin.com/company/…"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label for="social_twitter" class="block text-xs font-medium text-slate-600">X (Twitter)</label>
                    <input id="social_twitter" name="social_twitter" type="url" value="{{ $value('social_twitter') }}"
                           placeholder="https://twitter.com/DPM_UII"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <p class="mt-1 text-xs text-slate-500">Akun X yang tercatat mungkin sudah tidak aktif.</p>
                </div>
                <div>
                    <label for="social_youtube" class="block text-xs font-medium text-slate-600">YouTube</label>
                    <input id="social_youtube" name="social_youtube" type="url" value="{{ $value('social_youtube') }}"
                           placeholder="Isi hanya jika URL channel sudah diketahui"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label for="social_facebook" class="block text-xs font-medium text-slate-600">Facebook</label>
                    <input id="social_facebook" name="social_facebook" type="url" value="{{ $value('social_facebook') }}"
                           placeholder="https://facebook.com/…"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
            </div>
        </div>

        <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-semibold text-slate-900">SEO</h2>

            <div>
                <label for="meta_description" class="block text-xs font-medium text-slate-600">Meta description</label>
                <textarea id="meta_description" name="meta_description" rows="4" maxlength="320"
                          class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ $value('meta_description') }}</textarea>
            </div>

            <button type="submit" class="w-full rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-800">
                Simpan pengaturan
            </button>
        </div>
    </form>
@endsection
