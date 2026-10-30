<div class="rounded-xl border border-slate-200 p-4">
    <div class="flex items-start justify-between gap-3">
        <div class="flex min-w-0 items-start gap-3">
            @if ($official->photo_url)
                <img src="{{ $official->photo_url }}" alt="{{ $official->name }}"
                     class="h-14 w-14 shrink-0 rounded-lg object-cover">
            @else
                <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-sm font-semibold text-slate-500">
                    {{ \Illuminate\Support\Str::substr($official->name, 0, 1) }}
                </span>
            @endif

            <div class="min-w-0">
                <p class="text-sm font-semibold text-slate-900">{{ $official->name }}</p>
                @if ($official->description)
                    <p class="text-xs text-slate-600">{{ $official->description }}</p>
                @endif
                <p class="text-xs text-slate-500">
                    {{ $official->position ?: 'Tanpa jabatan' }}
                    @if ($official->period) · {{ $official->period->name }} @endif
                </p>
            </div>
        </div>

        <div class="flex shrink-0 items-center gap-2">
            <span @class([
                'rounded-full px-2 py-0.5 text-[11px] font-medium',
                'bg-emerald-50 text-emerald-700' => $official->is_active,
                'bg-slate-100 text-slate-600' => ! $official->is_active,
            ])>{{ $official->is_active ? 'Tampil' : 'Disembunyikan' }}</span>
            <form method="POST" action="{{ route('admin.units.officials.destroy', [$unit, $official]) }}"
                  onsubmit="return confirm('Hapus {{ $official->name }}?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs font-semibold text-red-600 hover:underline">Hapus</button>
            </form>
        </div>
    </div>

    <details class="mt-3">
        <summary class="cursor-pointer text-xs font-semibold text-[#0B3C8D]">Ubah data</summary>

        <form method="POST" action="{{ route('admin.units.officials.update', [$unit, $official]) }}"
              enctype="multipart/form-data" class="mt-3 grid gap-3 sm:grid-cols-2">
            @csrf
            @method('PUT')

            @include('admin.units.partials.official-fields', ['official' => $official])

            <div class="sm:col-span-2">
                <button type="submit" class="rounded-lg bg-[#0B3C8D] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#08285C]">
                    Simpan perubahan
                </button>
            </div>
        </form>
    </details>
</div>
