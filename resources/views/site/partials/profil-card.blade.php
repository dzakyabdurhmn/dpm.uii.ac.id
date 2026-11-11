@php
    $url = $profil->nim ? route('profil-dewan.detail', $profil->nim) : null;
    $meta = collect([$profil->fakultas, $profil->program_studi])->filter()->implode(' · ');
    $initials = strtoupper(implode('', array_map(
        fn (string $kata) => mb_substr($kata, 0, 1),
        array_slice(explode(' ', trim($profil->nama_lengkap)), 0, 2)
    )));
@endphp
@if ($url)<a class="pc" href="{{ $url }}">@else<div class="pc">@endif
    <div class="av">
        <svg class="sil" viewBox="0 0 100 120" aria-hidden="true"><circle cx="50" cy="40" r="20"/><path d="M12 120c0-26 17-42 38-42s38 16 38 42z"/></svg>
        @if ($foto)
            <img src="{{ asset($foto) }}" alt="Foto {{ $profil->nama_lengkap }}" loading="lazy" onerror="this.remove()">
        @else
            <b>{{ $initials }}</b>
        @endif
    </div>
    <div class="pc-i">
        <small>{{ $profil->jabatan }}</small>
        <h3>{{ $profil->nama_lengkap }}</h3>
        @if ($meta)<span>{{ $meta }}</span>@endif
        @if ($url)<em>Lihat profil</em>@endif
    </div>
@if ($url)</a>@else</div>@endif
