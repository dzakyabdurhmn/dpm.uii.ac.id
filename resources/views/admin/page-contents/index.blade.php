@extends('layouts.admin')

@section('title', 'Konten Halaman')
@section('heading', 'Konten Halaman')
@section('subheading', 'Kelola isi halaman statis (hanya Sambutan Ketua yang punya editor)')

@section('content')
<div class="rounded-2xl border border-slate-200 bg-white p-5">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500 border-b border-slate-200">
                <th class="pb-3 pr-4">Seksi</th>
                <th class="pb-3 pr-4">Subtitle</th>
                <th class="pb-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach ($sections as $key => $config)
                <tr class="hover:bg-slate-50">
                    <td class="py-4 pr-4 font-medium text-slate-900">{{ $config['title'] }}</td>
                    <td class="py-4 pr-4 text-slate-600">{{ $config['subtitle'] }}</td>
                    <td class="py-4">
                        <a href="{{ route('admin.page-contents.edit', $key) }}"
                           class="text-sm font-medium text-[#0B3C8D] hover:underline">
                            {{ $contents->has($key) ? 'Edit' : 'Isi' }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection