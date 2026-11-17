@php
    $official = $official ?? null;
    $periods = $periods ?? collect();
    $defaultPeriodId = $defaultPeriodId ?? $official?->period_id;
    $selectedPeriod = old('period_id', $defaultPeriodId);
@endphp

<div class="sm:col-span-2">
    <label for="official-name-{{ $official?->id ?? 'new' }}" class="block text-xs font-medium text-slate-600">
        Nama lengkap <span class="text-red-500">*</span>
    </label>
    <input id="official-name-{{ $official?->id ?? 'new' }}" name="name" type="text" required
           value="{{ old('name', $official->name ?? '') }}" placeholder="Nama sesuai data akademik"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
</div>

<div class="sm:col-span-2">
    <label for="official-position-{{ $official?->id ?? 'new' }}" class="block text-xs font-medium text-slate-600">
        Jabatan
    </label>
    <input id="official-position-{{ $official?->id ?? 'new' }}" name="position" type="text"
           value="{{ old('position', $official->position ?? '') }}"
           placeholder="Ketua / Sekretaris / Kabiro / Staf"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
    <p class="mt-1 text-xs text-slate-400">
        Jabatan diawali "Kepala", "Ketua", "Presiden", atau "Direktur" akan tampil sebagai pemimpin unit.
    </p>
</div>

<div>
    <label for="official-period-{{ $official?->id ?? 'new' }}" class="block text-xs font-medium text-slate-600">Periode</label>
    <select id="official-period-{{ $official?->id ?? 'new' }}" name="period_id"
            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
        <option value="">— Tanpa periode —</option>
        @foreach ($periods as $period)
            <option value="{{ $period->id }}" @selected((string) $selectedPeriod === (string) $period->id)>
                {{ $period->name }}{{ $period->is_active ? ' (aktif)' : '' }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label for="official-sort-{{ $official?->id ?? 'new' }}" class="block text-xs font-medium text-slate-600">Urutan</label>
    <input id="official-sort-{{ $official?->id ?? 'new' }}" name="sort_order" type="number" min="0"
           value="{{ old('sort_order', $official->sort_order ?? 0) }}"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
</div>

<div>
    <label class="block text-xs font-medium text-slate-600">Fakultas</label>
    <input name="fakultas" type="text" value="{{ old('fakultas', $official->fakultas ?? '') }}"
           placeholder="Fakultas Hukum"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
</div>

<div>
    <label class="block text-xs font-medium text-slate-600">Program studi</label>
    <input name="prodi" type="text" value="{{ old('prodi', $official->prodi ?? '') }}"
           placeholder="Ilmu Hukum"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
</div>

<div>
    <label class="block text-xs font-medium text-slate-600">Angkatan</label>
    <input name="angkatan" type="text" value="{{ old('angkatan', $official->angkatan ?? '') }}"
           placeholder="2023"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
</div>

<div>
    <label class="block text-xs font-medium text-slate-600">NIM</label>
    <input name="nim" type="text" value="{{ old('nim', $official->nim ?? '') }}"
           placeholder="21522045"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
</div>

<div>
    <label class="block text-xs font-medium text-slate-600">Email</label>
    <input name="email" type="email" value="{{ old('email', $official->email ?? '') }}"
           placeholder="nama@students.uii.ac.id"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
</div>

<div>
    <label class="block text-xs font-medium text-slate-600">Instagram</label>
    <input name="instagram" type="text" value="{{ old('instagram', $official->instagram ?? '') }}"
           placeholder="https://instagram.com/…"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
</div>

<div class="sm:col-span-2">
    <label class="block text-xs font-medium text-slate-600">LinkedIn</label>
    <input name="linkedin" type="text" value="{{ old('linkedin', $official->linkedin ?? '') }}"
           placeholder="https://linkedin.com/in/…"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
</div>

<div class="sm:col-span-2">
    <label class="block text-xs font-medium text-slate-600">Deskripsi singkat</label>
    <input name="description" type="text" value="{{ old('description', $official->description ?? '') }}"
           placeholder="Keterangan tambahan (opsional)"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
</div>

<div class="sm:col-span-2">
    <label class="block text-xs font-medium text-slate-600">Foto</label>
    <input name="photo" type="file" accept="image/*"
           class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
    @if ($official?->photo_url)
        <img src="{{ $official->photo_url }}" alt="{{ $official->name }}"
             class="mt-2 h-16 w-16 rounded-lg object-cover">
    @endif
</div>

<label class="flex items-center gap-2 text-sm text-slate-700 sm:col-span-2">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $official->is_active ?? true))>
    Tampilkan di halaman publik
</label>
