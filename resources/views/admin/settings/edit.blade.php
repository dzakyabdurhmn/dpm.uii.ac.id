@extends('layouts.admin')

@php
    $value = fn (string $key) => old($key, $settings[$key] ?? '');
@endphp

@section('title', 'Pengaturan')
@section('heading', 'Pengaturan situs')
@section('subheading', 'Email dan nomor telepon kontak DPM UII')

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6">
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

            <button type="submit" class="w-full rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-800">
                Simpan pengaturan
            </button>
        </div>
    </form>
@endsection
