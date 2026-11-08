@extends('layouts.admin')

@section('title', 'Distribusi Dana')
@section('heading', 'Distribusi Dana')
@section('subheading', 'Riwayat semua triwulan semua periode')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-sm font-semibold text-slate-900">Riwayat Triwulan</h2>
        <p class="text-xs text-slate-500">Semua data distribusi dana per triwulan per periode</p>
    </div>
    <a href="{{ route('admin.distribusi-dana.create') }}"
       class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
        Tambah Triwulan
    </a>
</div>

<div class="rounded-2xl border border-slate-200 bg-white overflow-hidden">
    @if ($triwulanList->isEmpty())
        <div class="p-8 text-center text-slate-500">
            Belum ada data triwulan. Klik <a href="{{ route('admin.distribusi-dana.create') }}" class="text-[#0B3C8D] underline">Tambah Triwulan</a> untuk memulai.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <th class="p-4">Periode</th>
                        <th class="p-4">Triwulan</th>
                        <th class="p-4">Total Dana</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($triwulanList as $t)
                        <tr class="hover:bg-slate-50">
                            <td class="p-4 font-medium text-slate-900">{{ $t->periode->name }}</td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Triwulan {{ $t->triwulan }}
                                </span>
                            </td>
                            <td class="p-4 font-mono text-slate-700">Rp {{ number_format($t->total_dana, 0, ',', '.') }}</td>
                            <td class="p-4">
                                @if ($t->status === 'terbit')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Terbit</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Draft</span>
                                @endif
                            </td>
                            <td class="p-4 text-slate-500">{{ $t->created_at->format('d M Y H:i') }}</td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.distribusi-dana.edit', $t) }}"
                                       class="text-sm font-medium text-[#0B3C8D] hover:underline">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.distribusi-dana.destroy', $t) }}" onsubmit="return confirm('Hapus triwulan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200">
            {{ $triwulanList->links() }}
        </div>
    @endif
</div>
@endsection