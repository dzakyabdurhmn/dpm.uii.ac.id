@extends('layouts.admin')

@section('title', 'Balas Aspirasi · {{ $aspirasi->ticket_number }}')
@section('heading', 'Balas Aspirasi')
@section('subheading', 'Tanggapi aspirasi yang masuk dari mahasiswa')

@section('content')
    <div class="flex items-center justify-between gap-3 mb-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-4">
            <h2 class="text-sm font-semibold text-slate-900">{{ $aspirasi->ticket_number }}</h2>
            <p class="text-xs text-slate-500">{{ $aspirasi->name ?? '(Anonim)' }} · {{ $aspirasi->faculty ?? '-' }} · {{ $aspirasi->created_at->format('d M Y H:i') }}</p>
        </div>

        <a href="{{ route('admin.aspirasi.index') }}"
           class="text-sm text-[#0B3C8D] hover:underline">← Kembali ke daftar</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <h3 class="text-xs font-semibold text-slate-600 mb-3 uppercase tracking-wide">Detail Aspirasi</h3>
            <p class="text-sm text-slate-600 mb-3">{{ $aspirasi->subject }}</p>
            <div class="rounded-lg border border-slate-200 p-4 text-sm text-slate-700 whitespace-pre-wrap">
                {{ $aspirasi->message }}
            </div>

            <div class="mt-4 grid gap-3 sm:grid-cols-2 text-xs text-slate-500">
                <div><span class="font-medium text-slate-700">Nama:</span> {{ $aspirasi->name ?? '(Anonim)' }}</div>
                <div><span class="font-medium text-slate-700">NIM:</span> {{ $aspirasi->student_id ?? '-' }}</div>
                <div><span class="font-medium text-slate-700">Fakultas:</span> {{ $aspirasi->faculty ?? '-' }}</div>
                <div><span class="font-medium text-slate-700">Email:</span> {{ $aspirasi->email ?? '-' }}</div>
                <div><span class="font-medium text-slate-700">Telepon:</span> {{ $aspirasi->phone ?? '-' }}</div>
                <div><span class="font-medium text-slate-700">Kategori:</span> {{ $aspirasi->category }}</div>
            </div>

            @if ($aspirasi->response)
                <div class="mt-4 rounded-lg bg-emerald-50 p-4">
                    <p class="text-xs font-semibold text-emerald-700 mb-1">Balasan sebelumnya:</p>
                    <p class="text-sm text-emerald-800">{{ $aspirasi->response }}</p>
                    <p class="text-[10px] text-emerald-600 mt-1">{{ $aspirasi->responded_at?->format('d M Y H:i') }}</p>
                </div>
            @endif
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <form method="POST" action="{{ route('admin.aspirasi.update', $aspirasi) }}"
                  class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="status" class="block text-xs font-medium text-slate-600">Status</label>
                    <select id="status" name="status"
                            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        <option value="baru" @selected($aspirasi->status === 'baru')>Baru</option>
                        <option value="diproses" @selected($aspirasi->status === 'diproses')>Diproses</option>
                        <option value="selesai" @selected($aspirasi->status === 'selesai')>Selesai</option>
                        <option value="ditolak" @selected($aspirasi->status === 'ditolak')>Ditolak</option>
                    </select>
                </div>

                <div>
                    <label for="response" class="block text-xs font-medium text-slate-600">Balasan <span class="text-red-500">*</span></label>
                    <textarea id="response" name="response" rows="5" required
                              class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('response', $aspirasi->response) }}</textarea>
                    @error('response') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit"
                        class="rounded-lg bg-[#0B3C8D] px-4 py-2 text-sm font-semibold text-white hover:bg-[#08285C]">
                    Kirim balasan
                </button>
            </form>
        </div>
    </div>
@endsection
