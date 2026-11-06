@php($official = $official ?? null)

<div>
    <label class="block text-xs font-medium text-slate-600">Nama anggota</label>
    <input name="name" type="text" required value="{{ old('name', $official->name ?? '') }}"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-xs font-medium text-slate-600">Fakultas</label>
        <input name="fakultas" type="text" value="{{ old('fakultas', $official->fakultas ?? '') }}"
               placeholder="Fakultas Hukum"
               class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-slate-600">Program Studi</label>
        <input name="prodi" type="text" value="{{ old('prodi', $official->prodi ?? '') }}"
               placeholder="Ilmu Hukum"
               class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
</div>

<div>
    <label class="block text-xs font-medium text-slate-600">Deskripsi</label>
    <input name="description" type="text" value="{{ old('description', $official->description ?? '') }}"
           placeholder="Keterangan tambahan"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
</div>

<div>
    <label class="block text-xs font-medium text-slate-600">Periode</label>
    <select name="period_id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
        <option value="">—</option>
        @foreach ($periods as $period)
            <option value="{{ $period->id }}" @selected((string) old('period_id', $official->period_id ?? '') === (string) $period->id)>
                {{ $period->name }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label class="block text-xs font-medium text-slate-600">Jabatan (opsional)</label>
    <input name="position" type="text" value="{{ old('position', $official->position ?? '') }}"
           placeholder="Ketua / Sekretaris / Bendahara / Anggota"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
</div>

<div>
    <label class="block text-xs font-medium text-slate-600">Urutan</label>
    <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $official->sort_order ?? 0) }}"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
</div>

<div>
    <label class="block text-xs font-medium text-slate-600">Email</label>
    <input name="email" type="email" value="{{ old('email', $official->email ?? '') }}"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
</div>

<div>
    <label class="block text-xs font-medium text-slate-600">Instagram</label>
    <input name="instagram" type="text" value="{{ old('instagram', $official->instagram ?? '') }}"
           placeholder="https://instagram.com/…"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
</div>

<div>
    <label class="block text-xs font-medium text-slate-600">LinkedIn</label>
    <input name="linkedin" type="text" value="{{ old('linkedin', $official->linkedin ?? '') }}"
           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
</div>

<div>
    <label class="block text-xs font-medium text-slate-600">Foto</label>
    <input name="photo" type="file" accept="image/*"
           class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
    @if ($official?->photo_url)
        <img src="{{ $official->photo_url }}" alt="{{ $official->name }}"
             class="mt-2 h-16 w-16 rounded-lg object-cover">
    @endif
</div>

<label class="flex items-center gap-2 text-sm text-slate-700">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $official->is_active ?? true))>
    Tampilkan
</label>
