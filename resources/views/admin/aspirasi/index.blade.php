@extends('layouts.admin')

@section('title', 'Aspirasi')
@section('heading', 'Aspirasi Masyarakat')
@section('subheading', 'Kelola aspirasi dan pengaduan yang masuk dari landing page')

@section('content')
    <div class="flex items-center justify-between gap-3 mb-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-4">
            <h2 class="text-sm font-semibold text-slate-900">{{ $aspirasi->total() }} Aspirasi</h2>
            <p class="text-xs text-slate-500">{{ $aspirasi->where('status', 'baru')->count() }} baru · {{ $aspirasi->where('status', 'diproses')->count() }} diproses</p>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <form method="GET" class="grid gap-3 sm:grid-cols-3 items-end">
            <div>
                <label for="search" class="block text-xs font-medium text-slate-600">Cari</label>
                <input id="search" name="search" type="text" placeholder="Nomor tiket, nama, subjek…"
                       value="{{ request('search') }}"
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label for="status" class="block text-xs font-medium text-slate-600">Status</label>
                <select id="status" name="status"
                        class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option value="">Semua</option>
                    <option value="baru" @selected(request('status') === 'baru')>Baru</option>
                    <option value="diproses" @selected(request('status') === 'diproses')>Diproses</option>
                    <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
                    <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
                </select>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Tiket</th>
                    <th class="px-5 py-3">Nama</th>
                    <th class="px-5 py-3">Fakultas</th>
                    <th class="px-5 py-3">Subjek</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($aspirasi as $a)
                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900">{{ $a->ticket_number }}</td>
                        <td class="px-5 py-3">
                            {{ $a->name ?? '(Anonim)' }}
                            <p class="text-xs text-slate-500">{{ $a->student_id ?? '-' }}</p>
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $a->faculty ?? '-' }}</td>
                        <td class="px-5 py-3">{{ $a->subject }}</td>
                        <td class="px-5 py-3">
                            <span @class([
                                'rounded-full px-2 py-0.5 text-[11px] font-medium',
                                'bg-emerald-50 text-emerald-700' => $a->status === 'selesai',
                                'bg-blue-50 text-blue-700' => $a->status === 'diproses',
                                'bg-amber-50 text-amber-700' => $a->status === 'baru',
                                'bg-red-50 text-red-700' => $a->status === 'ditolak',
                            ])>{{ ucfirst($a->status) }}</span>
                        </td>
                        <td class="px-5 py-3">
                            <a href="{{ route('admin.aspirasi.edit', $a) }}"
                               class="rounded-lg bg-[#0B3C8D] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#08285C]">
                                Balas
                            </a>
                            <form method="POST" action="{{ route('admin.aspirasi.destroy', $a) }}"
                                  class="inline"
                                  onsubmit="return confirm('Hapus aspirasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-100">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-sm text-slate-500">Belum ada aspirasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $aspirasi->links() }}
@endsection
