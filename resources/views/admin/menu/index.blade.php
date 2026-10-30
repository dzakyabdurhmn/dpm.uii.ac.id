@extends('layouts.admin')

@section('title', 'Menu Navigasi')
@section('heading', 'Menu Navigasi')
@section('subheading', 'Susunan menu header situs')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <p class="text-sm text-slate-600">Perubahan langsung tampil di navigasi situs.</p>
        <a href="{{ route('admin.menu.create') }}"
           class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
            Tambah item
        </a>
    </div>

    <div class="space-y-3">
        @forelse ($items as $item)
            <div class="rounded-2xl border border-slate-200 bg-white p-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">
                            {{ $item->label }}
                            @unless ($item->is_active)
                                <span class="ml-2 rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-medium text-slate-600">nonaktif</span>
                            @endunless
                        </p>
                        <p class="text-xs text-slate-500">{{ $item->url ?: '—' }} · urutan {{ $item->sort_order }}</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.menu.create', ['parent' => $item->id]) }}"
                           class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-200">
                            Submenu
                        </a>
                        <a href="{{ route('admin.menu.edit', $item) }}"
                           class="rounded-lg bg-[#0B3C8D] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#08285C]">
                            Ubah
                        </a>
                        <form method="POST" action="{{ route('admin.menu.destroy', $item) }}"
                              onsubmit="return confirm('Hapus menu {{ $item->label }} beserta submenunya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

                @if ($item->children->isNotEmpty())
                    <ul class="mt-3 space-y-2 border-l-2 border-slate-100 pl-4">
                        @foreach ($item->children as $child)
                            <li class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-sm text-slate-800">{{ $child->label }}</p>
                                    <p class="text-xs text-slate-500">{{ $child->url ?: '—' }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.menu.edit', $child) }}"
                                       class="text-xs font-semibold text-[#0B3C8D] hover:underline">Ubah</a>
                                    <form method="POST" action="{{ route('admin.menu.destroy', $child) }}"
                                          onsubmit="return confirm('Hapus menu {{ $child->label }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @empty
            <p class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-500">
                Belum ada item menu.
            </p>
        @endforelse
    </div>
@endsection
