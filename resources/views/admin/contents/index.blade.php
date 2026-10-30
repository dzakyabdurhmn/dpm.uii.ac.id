@extends('layouts.admin')

@section('title', 'Konten Halaman')
@section('heading', 'Konten Halaman')
@section('subheading', 'Bagian halaman tetap — hanya isi yang dapat diubah')

@section('content')
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Bagian</th>
                    <th class="px-5 py-3">URL</th>
                    <th class="px-5 py-3">Status isi</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($sections as $key => $section)
                    @php($content = $contents[$key] ?? null)
                    <tr>
                        <td class="px-5 py-3">
                            <p class="font-medium text-slate-900">{{ $section['title'] }}</p>
                            <p class="text-xs text-slate-500">{{ $section['subtitle'] }}</p>
                        </td>
                        <td class="px-5 py-3 text-xs text-slate-500">/tentang/{{ $key }}</td>
                        <td class="px-5 py-3">
                            <span @class([
                                'rounded-full px-2 py-0.5 text-[11px] font-medium',
                                'bg-emerald-50 text-emerald-700' => filled($content?->body),
                                'bg-amber-50 text-amber-700' => ! filled($content?->body),
                            ])>{{ filled($content?->body) ? 'Terisi' : 'Kosong' }}</span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.contents.edit', $key) }}"
                               class="rounded-lg bg-[#0B3C8D] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#08285C]">
                                Ubah
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
