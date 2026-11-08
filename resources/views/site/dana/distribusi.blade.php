@extends('layouts.site')

@section('title', 'Distribusi Dana — DPM UII')
@section('meta_description', 'Transparansi distribusi dana DPM UII periode '.$periode->name.' '.$triwulanLabel($triwulan->triwulan).'.')

@push('styles')
<style>
  html { scroll-padding-top: 100px; }
  .pg-head { position: relative; overflow: hidden; border-bottom: 1px solid var(--b-default); padding: 56px 0 64px;
    background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); }
  .pg-head::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px); }
  .hero-grid { position: relative; display: grid; grid-template-columns: 1.2fr .8fr; gap: 40px; align-items: center; }
  .crumb { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 28px; font-size: 12.5px; color: var(--t-cap); }
  .crumb a { transition: color .2s; } .crumb a:hover { color: var(--white); }
  .crumb span[aria-hidden] { opacity: .5; }
  .crumb span[aria-current] { color: var(--white); font-weight: 600; }
  .pg-head h1 { font-size: clamp(34px, 5.6vw, 62px); letter-spacing: -1.6px; line-height: 1.06; margin-bottom: 18px; }
  .pg-desc { max-width: 580px; margin-bottom: 28px; font-size: 16px; color: var(--t-sub); }
  .flt { display: flex; flex-wrap: wrap; gap: 16px 32px; margin-top: 24px; } .fg small { display: block; margin-bottom: 8px; font-size: 11px; font-weight: 600; letter-spacing: 1.8px; text-transform: uppercase; color: var(--t-cap); }
  .tw { display: inline-flex; gap: 4px; padding: 4px; border: 1px solid var(--b-btn); border-radius: 100px; background: var(--navy-card); }
  .tw a, .tw span { padding: 9px 18px; border-radius: 100px; font-size: 13.5px; font-weight: 600; }
  .tw a[aria-current="page"] { background: var(--navy-hover); color: var(--white); box-shadow: inset 0 0 0 1px var(--b-btn-hover); } .tw span { color: var(--t-cap); opacity: .55; cursor: not-allowed; }
  .src { margin-top: 14px; font-size: 12.5px; color: var(--t-cap); line-height: 1.7; }
  .dd-nav { position: sticky; top: 72px; z-index: 30; border-bottom: 1px solid var(--b-default); background: rgba(0,30,67,.94); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
  .dd-nav .container { display: flex; gap: 6px; overflow-x: auto; padding-top: 10px; padding-bottom: 10px; }
  .dd-nav a { flex: none; padding: 7px 14px; border: 1px solid transparent; border-radius: 100px; font-size: 13px; font-weight: 600; color: var(--t-sub); white-space: nowrap; transition: background .2s, color .2s, border-color .2s; }
  .dd-nav a:hover { background: var(--bg-hover); color: var(--white); } .dd-nav a.on { border-color: var(--b-btn-hover); background: var(--navy-hover); color: var(--white); }
  .dd-sec { padding: 64px 0; border-bottom: 1px solid var(--b-default); } .dd-sec.alt { background: var(--navy-card); }
  .dd-h { margin-bottom: 28px; max-width: 720px; } .dd-h .no { display: block; margin-bottom: 8px; font-size: 12px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--t-cap); }
  .dd-h h2 { font-size: clamp(26px, 3.4vw, 38px); letter-spacing: -.9px; line-height: 1.2; }
  .total { display: grid; grid-template-columns: minmax(0,1.1fr) minmax(0,1fr); gap: 20px; align-items: stretch; }
  .big { padding: 32px 36px; border: 1px solid var(--b-btn-hover); border-radius: 12px; background: linear-gradient(135deg, #002A5A 0%, #001A3A 70%); box-shadow: var(--sh-md); }
  .big small, .kc small { display: block; font-size: 11px; font-weight: 600; letter-spacing: 1.8px; text-transform: uppercase; color: var(--t-cap); }
  .big b { display: block; margin-top: 10px; font-family: 'Wix Madefor Display', sans-serif; font-size: clamp(34px, 5vw, 54px); font-weight: 800; letter-spacing: -2px; line-height: 1.05; }
  .big .pr { margin-top: 28px; } .pr .t { display: flex; justify-content: space-between; align-items: baseline; font-size: 14px; color: var(--t-sub); } .pr .t b { display: inline; margin: 0; font-size: 28px; letter-spacing: -1px; }
  .pr i { display: block; height: 8px; margin-top: 10px; border-radius: 100px; background: rgba(255,255,255,.12); overflow: hidden; } .pr i u { display: block; height: 100%; width: var(--w); border-radius: 100px; background: var(--white); }
  .kcs { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .kc { padding: 22px 22px; border: 1px solid var(--b-btn); border-radius: 12px; background: var(--navy-card); } .kc.hl { border-color: var(--b-btn-hover); background: var(--navy-hover); }
  .kc b { display: block; margin-top: 8px; font-family: 'Wix Madefor Display', sans-serif; font-size: 20px; letter-spacing: -.4px; }
  .fyi { display: flex; gap: 14px; align-items: flex-start; margin-top: 24px; padding: 16px 20px; border-left: 2px solid var(--b-btn-hover); border-radius: 0 8px 8px 0; background: rgba(255,255,255,.04); font-size: 14.5px; line-height: 1.75; color: var(--t-body); max-width: 760px; }
  .fyi::before { content: 'Info'; flex: none; padding: 1px 10px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 10.5px; font-weight: 600; letter-spacing: 1.2px; text-transform: uppercase; color: var(--white); margin-top: 3px; }
  .split { display: grid; grid-template-columns: 300px minmax(0,1fr); gap: 48px; align-items: center; }
  .donut { position: relative; width: 280px; height: 280px; border-radius: 50%; background: conic-gradient(var(--white) 0 31%, #2D4A7A 31% 100%); box-shadow: var(--sh-md); }
  .donut::after { content: ''; position: absolute; inset: 56px; border-radius: 50%; background: var(--navy); } .donut span { position: absolute; inset: 0; z-index: 2; display: grid; place-content: center; text-align: center; font-size: 12px; color: var(--t-cap); } .donut span b { display: block; font-family: 'Wix Madefor Display', sans-serif; font-size: 22px; color: var(--white); }
  .legend { display: grid; gap: 14px; } .lg2 { display: grid; grid-template-columns: 14px 1fr auto; gap: 16px; align-items: center; padding: 22px 26px; border: 1px solid var(--b-btn); border-radius: 12px; background: var(--navy-card); }
  .lg2 .sw { width: 14px; height: 14px; border-radius: 4px; background: var(--white); } .lg2 .sw.b { background: #2D4A7A; border: 1px solid var(--b-btn); }
  .lg2 h3 { font-size: 18px; } .lg2 p { font-size: 13px; color: var(--t-cap); } .lg2 b { font-family: 'Wix Madefor Display', sans-serif; font-size: 24px; letter-spacing: -.6px; }
  .tot { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 12px 40px; align-items: baseline; margin-bottom: 20px; padding: 18px 24px; border: 1px solid var(--b-btn); border-radius: 12px; background: var(--navy-card); }
  .tot small { font-size: 11px; font-weight: 600; letter-spacing: 1.8px; text-transform: uppercase; color: var(--t-cap); } .tot b { font-family: 'Wix Madefor Display', sans-serif; font-size: 28px; letter-spacing: -.8px; }
  .bl { list-style: none; padding: 24px 28px; display: grid; gap: 16px; border: 1px solid var(--b-btn); border-radius: 12px; background: var(--navy-card); }
  .bl li { display: grid; grid-template-columns: 220px minmax(0,1fr) 170px; gap: 18px; align-items: center; }
  .bl .l { font-size: 14.5px; font-weight: 500; color: var(--t-body); } .bl .b { display: block; height: 14px; border-radius: 4px; background: rgba(255,255,255,.08); overflow: hidden; } .bl .b u { display: block; height: 100%; width: var(--w); border-radius: 4px; background: var(--white); opacity: .88; }
  .bl .v { text-align: right; font-family: 'Wix Madefor Display', sans-serif; font-size: 16px; font-weight: 700; } .bl .v small { display: block; font-family: 'Inter', sans-serif; font-size: 12.5px; font-weight: 500; color: var(--t-cap); }
  .bl.nf .v small { font-size: 15px; font-weight: 700; color: var(--white); font-family: 'Wix Madefor Display', sans-serif; }
  .sub { margin-top: 20px; } .sub h3 { margin-bottom: 12px; font-size: 13px; font-weight: 600; letter-spacing: 1.6px; text-transform: uppercase; color: var(--t-cap); font-family: 'Inter', sans-serif; }
  .chips4 { display: grid; grid-template-columns: repeat(4, minmax(0,1fr)); gap: 12px; } .chips4 div { padding: 18px 20px; border: 1px solid var(--b-btn); border-radius: 12px; background: var(--navy-card); } .chips4 b { display: block; font-size: 15px; } .chips4 em { display: block; margin: 4px 0 2px; font-style: normal; font-family: 'Wix Madefor Display', sans-serif; font-size: 22px; font-weight: 800; } .chips4 small { font-size: 12.5px; color: var(--t-cap); }
  .tbw { overflow-x: auto; border: 1px solid var(--b-btn); border-radius: 12px; background: var(--navy-card); }
  .tb { width: 100%; min-width: 560px; border-collapse: collapse; } .tb th, .tb td { padding: 14px 22px; text-align: left; border-bottom: 1px solid var(--b-default); font-size: 14.5px; } .tb tr:last-child td { border-bottom: 0; }
  .tb th { font-size: 11px; font-weight: 600; letter-spacing: 1.6px; text-transform: uppercase; color: var(--t-cap); background: var(--navy-footer); } .tb td.n, .tb th.n { text-align: right; font-variant-numeric: tabular-nums; }
  .tb td:first-child { color: var(--white); } .tb td i.rk { display: inline-block; width: 24px; margin-right: 8px; color: var(--t-cap); font-style: normal; font-size: 12.5px; }
  .tb .rb { display: block; width: 100%; min-width: 90px; height: 10px; border-radius: 3px; background: rgba(255,255,255,.08); overflow: hidden; } .tb .rb u { display: block; height: 100%; width: var(--w); background: var(--white); opacity: .85; border-radius: 3px; }
  .tb tfoot td { border-top: 1px solid var(--b-btn); border-bottom: 0; font-weight: 700; color: var(--white); background: rgba(255,255,255,.04); }
  .dd-end { padding: 40px 0 88px; }
  @media (max-width: 1080px) { .total, .split { grid-template-columns: minmax(0,1fr); } .split { justify-items: center; } .legend { width: 100%; } .chips4 { grid-template-columns: repeat(2, minmax(0,1fr)); } .bl li { grid-template-columns: 170px minmax(0,1fr) 140px; } }
  @media (max-width: 720px) { .flt, .fg { max-width: 100%; min-width: 0; } .tw { max-width: 100%; overflow-x: auto; } .tw a, .tw span { white-space: nowrap; padding: 9px 14px; } .dd-sec { padding: 44px 0; } .big { padding: 24px 22px; } .kcs { grid-template-columns: 1fr; } .donut { width: 220px; height: 220px; } .donut::after { inset: 44px; } .bl { padding: 20px; } .bl li { grid-template-columns: minmax(0,1fr) auto; gap: 8px 12px; } .bl .b { grid-column: 1 / -1; grid-row: 2; } .bl .l { grid-row: 1; } .bl .v { grid-row: 1; grid-column: 2; } .lg2 { padding: 18px; gap: 12px; } .lg2 b { font-size: 19px; } .tot b { font-size: 22px; } .tb th, .tb td { padding: 12px 14px; } }
</style>
@endpush

@section('content')
<!-- ================= HERO ================= -->
<section class="pg-head"><div class="container hero-grid"><div>
  <nav class="crumb" aria-label="Breadcrumb"><a href="/">Beranda</a><span aria-hidden="true">/</span><a href="{{ route('documents.dana') }}">Keuangan</a><span aria-hidden="true">/</span><span aria-current="page">Distribusi Dana</span></nav>
  <span class="eyebrow">Keuangan · Transparansi Dana</span><h1>Distribusi Dana</h1>
  <p class="pg-desc">Alokasi dana lembaga KM UII per triwulan: dari total dana, pembagian universitas dan fakultas, hingga dana taktis.</p>
  <div class="flt">
    <div class="fg"><small>Periode</small><div class="tw" role="group" aria-label="Pilih periode">
      @foreach($periods as $option)
        <a href="{{ route('dana.distribusi', ['periode' => $option->id]) }}" @if($option->id === $periode->id) aria-current="page" @endif>{{ $option->name }}</a>
      @endforeach
    </div></div>
    <div class="fg"><small>Triwulan</small><div class="tw" role="group" aria-label="Pilih triwulan">
      @foreach($triwulanOptions as $option)
        <a href="{{ route('dana.distribusi', ['periode' => $periode->id, 'triwulan' => $option->triwulan]) }}" @if($option->triwulan === $triwulan->triwulan) aria-current="page" @endif>{{ $triwulanLabel($option->triwulan) }}</a>
      @endforeach
    </div></div>
  </div>
  <p class="src">Menampilkan: Periode {{ $periode->name }} · {{ $triwulanLabel($triwulan->triwulan) }}</p></div></div></section>
<nav class="dd-nav" aria-label="Bagian halaman"><div class="container"><a href="#overview">Overview</a><a href="#pembagian">Pembagian</a><a href="#universitas">Universitas</a><a href="#fakultas">Fakultas</a><a href="#perfakultas">Per Fakultas</a><a href="#rasio">Rasio Mahasiswa</a><a href="#taktis">Dana Taktis</a></div></nav>

<!-- ================= OVERVIEW ================= -->
<section class="dd-sec" id="overview"><div class="container"><div class="dd-h"><span class="no">01</span><h2>Overview dana {{ $triwulanLabel($triwulan->triwulan) }}</h2></div>
  <div class="total"><div class="big"><small>Total dana {{ $triwulanLabel($triwulan->triwulan) }}</small><b>Rp {{ number_format($totalDana, 0, ',', '.') }}</b><div class="pr"><div class="t"><span>Dari total dana merupakan dana distribusi</span><b>±{{ $bilahPersen }}%</b></div><i><u style="--w:{{ $bilahPersen }}%"></u></i></div></div><div class="kcs"><div class="kc"><small>Dana Transisi</small><b>Rp {{ number_format($komponen->firstWhere('kode','transisi')?->jumlah ?? 0, 0, ',', '.') }}</b></div><div class="kc"><small>Dana Taktis</small><b>Rp {{ number_format($taktisTotal, 0, ',', '.') }}</b></div><div class="kc"><small>Pengembangan dan Pengelolaan Aset</small><b>Rp {{ number_format($komponen->firstWhere('kode','aset')?->jumlah ?? 0, 0, ',', '.') }}</b></div><div class="kc hl"><small>Dana Distribusi</small><b>Rp {{ number_format($distribusiTotal, 0, ',', '.') }}</b></div></div></div>
  <p class="fyi">Sekitar {{ $bilahPersen }}% dari total dana didistribusikan untuk mendukung lembaga mahasiswa di KM UII.</p></div></section>

<!-- ================= PEMBAGIAN ================= -->
<section class="dd-sec alt" id="pembagian"><div class="container"><div class="dd-h"><span class="no">02</span><h2>Distribusi dana: universitas dan fakultas</h2></div>
  <div class="split"><div class="donut" role="img" aria-label="Universitas {{ $universitasPersen }} persen, Fakultas {{ $fakultasPersen }} persen" style="background: conic-gradient(var(--white) 0 {{ $universitasPersen }}%, #2D4A7A {{ $universitasPersen }}% 100%)"><span><b>Rp {{ number_format($distribusiTotal, 0, ',', '.') }}</b>dana distribusi</span></div>
  <div class="legend"><div class="lg2"><i class="sw"></i><div><h3>Universitas ({{ $universitasPersen }}%)</h3><p>Lembaga tingkat universitas</p></div><b>Rp {{ number_format($universitasTotal, 0, ',', '.') }}</b></div><div class="lg2"><i class="sw b"></i><div><h3>Fakultas ({{ $fakultasPersen }}%)</h3><p>Organisasi tingkat fakultas</p></div><b>Rp {{ number_format($fakultasTotal, 0, ',', '.') }}</b></div></div></div>
  <p class="fyi">Porsi terbesar ({{ $fakultasPersen }}%) dialokasikan untuk organisasi tingkat fakultas.</p></div></section>

<!-- ================= UNIVERSITAS ================= -->
<section class="dd-sec" id="universitas"><div class="container"><div class="dd-h"><span class="no">03</span><h2>Dana tingkat universitas</h2></div>
  <div class="tot"><small>Total dana universitas</small><b>Rp {{ number_format($universitasTotal, 0, ',', '.') }}</b></div>
  <ul class="bl nf"><li><span class="l">Lembaga Khusus Universitas</span><i class="b"><u style="--w:100.0%"></u></i><span class="v">60%<small>Rp {{ number_format($universitasTotal * 0.60, 0, ',', '.') }}</small></span></li><li><span class="l">LEM Universitas</span><i class="b"><u style="--w:56.7%"></u></i><span class="v">34%<small>Rp {{ number_format($universitasTotal * 0.34, 0, ',', '.') }}</small></span></li><li><span class="l">DPM Universitas</span><i class="b"><u style="--w:10.0%"></u></i><span class="v">6%<small>Rp {{ number_format($universitasTotal * 0.06, 0, ',', '.') }}</small></span></li></ul>
  <div class="sub"><h3>Rincian Lembaga Khusus Universitas</h3><div class="chips4"><div><b>Mapala Unisi</b><em>35%</em><small>Rp {{ number_format($universitasTotal * 0.60 * 0.35, 0, ',', '.') }}</small></div><div><b>LPM Himmah</b><em>35%</em><small>Rp {{ number_format($universitasTotal * 0.60 * 0.35, 0, ',', '.') }}</small></div><div><b>Marching Band UII</b><em>30%</em><small>Rp {{ number_format($universitasTotal * 0.60 * 0.30, 0, ',', '.') }}</small></div><div><b>KOPMA UII</b><em>0%</em><small>Rp0</small></div></div></div>
  <p class="fyi">Sebanyak 60% dana universitas diperuntukkan bagi Lembaga Khusus Universitas.</p></div></section>

<!-- ================= FAKULTAS ================= -->
<section class="dd-sec alt" id="fakultas"><div class="container"><div class="dd-h"><span class="no">04</span><h2>Dana tingkat fakultas</h2></div>
  <div class="tot"><small>Total dana fakultas</small><b>Rp {{ number_format($fakultasTotal, 0, ',', '.') }}</b></div>
  <ul class="bl nf"><li><span class="l">LEM Fakultas</span><i class="b"><u style="--w:100.0%"></u></i><span class="v">62%<small>Rp {{ number_format($fakultasTotal * 0.62, 0, ',', '.') }}</small></span></li><li><span class="l">LPM Fakultas</span><i class="b"><u style="--w:51.6%"></u></i><span class="v">32%<small>Rp {{ number_format($fakultasTotal * 0.32, 0, ',', '.') }}</small></span></li><li><span class="l">DPM Fakultas</span><i class="b"><u style="--w:9.7%"></u></i><span class="v">6%<small>Rp {{ number_format($fakultasTotal * 0.06, 0, ',', '.') }}</small></span></li><li><span class="l">KOPMA Fakultas</span><i class="b"><u style="--w:0.0%"></u></i><span class="v">0%<small>Rp0</small></span></li></ul>
  <p class="fyi">Sebanyak {{ $fakultasPersen }}% dana {{ $triwulanLabel($triwulan->triwulan) }} dialokasikan bagi lembaga di fakultas.</p></div></section>

<!-- ================= PER FAKULTAS ================= -->
<section class="dd-sec" id="perfakultas"><div class="container"><div class="dd-h"><span class="no">05</span><h2>Total dana per fakultas</h2></div>
  <ul class="bl nf">
    @php $i = 1; @endphp
    @foreach($totalPerFakultas as $fp)
    <li><span class="l">{{ $i }}. {{ $fp['fakultas']->nama }}</span><i class="b"><u style="--w:100.0%"></u></i><span class="v">{{ number_format($fp['total'] / 1000000, 2, ',', '.') }}<small>juta rupiah</small></span></li>
    @php $i++; @endphp
    @endforeach
  </ul>
  <p class="fyi">{{ ($totalPerFakultas->first()['fakultas'] ?? null)?->nama ?? 'Fakultas terbesar' }} menjadi penerima dana terbesar pada {{ $triwulanLabel($triwulan->triwulan) }}.</p></div></section>

<!-- ================= RASIO ================= -->
<section class="dd-sec alt" id="rasio"><div class="container"><div class="dd-h"><span class="no">06</span><h2>Rasio mahasiswa per fakultas</h2></div>
  <div class="tbw"><table class="tb"><thead><tr><th>Fakultas</th><th class="n">Jumlah mahasiswa</th><th>Rasio</th><th class="n">%</th></tr></thead><tbody>
    @php $rk = 1; @endphp
    @foreach($mahasiswa->sortByDesc('jumlah_mahasiswa') as $m)
    <tr><td><i class="rk">{{ $rk }}</i>{{ $m->fakultas->nama }}</td><td class="n">{{ number_format($m->jumlah_mahasiswa, 0, ',', '.') }}</td><td><span class="rb"><u style="--w:{{ $totalMahasiswa > 0 ? round(($m->jumlah_mahasiswa / $totalMahasiswa) * 100, 1) : 0 }}%"></u></span></td><td class="n">{{ $totalMahasiswa > 0 ? number_format(($m->jumlah_mahasiswa / $totalMahasiswa) * 100, 2, ',', '.') : '0' }}%</td></tr>
    @php $rk++; @endphp
    @endforeach
    </tbody><tfoot><tr><td>Total</td><td class="n">{{ number_format($totalMahasiswa, 0, ',', '.') }}</td><td></td><td class="n">100%</td></tr></tfoot></table></div>
  <p class="fyi">Rasio mahasiswa menjadi salah satu dasar pembagian dana di tingkat fakultas.</p></div></section>

<!-- ================= TAKTIS ================= -->
<section class="dd-sec" id="taktis"><div class="container"><div class="dd-h"><span class="no">07</span><h2>Dana taktis</h2></div>
  <div class="tot"><small>Total dana taktis {{ $triwulanLabel($triwulan->triwulan) }}</small><b>Rp {{ number_format($taktisTotal, 0, ',', '.') }}</b></div>
  <div class="tbw"><table class="tb"><thead><tr><th>Distribusi</th><th class="n">Jumlah</th></tr></thead><tbody>
    @php $rk = 1; @endphp
    @foreach($alokasiTaktis as $t)
    <tr><td><i class="rk">{{ $rk }}</i>{{ $t->fakultas ? $t->fakultas->nama : 'Universitas' }}</td><td class="n">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td></tr>
    @php $rk++; @endphp
    @endforeach
    </tbody><tfoot><tr><td>Total terdistribusi</td><td class="n">Rp {{ number_format($alokasiTaktis->sum('jumlah'), 0, ',', '.') }}</td></tr></tfoot></table></div>
  <p class="fyi">Sisa dana taktis {{ $triwulanLabel($triwulan->triwulan) }}, yaitu Rp {{ number_format($taktisSisa, 0, ',', '.') }}, akan digunakan sebagai dana cadangan untuk mendukung pelaksanaan kegiatan Pesta dan Pekta.</p></div></section>

<section class="dd-end"><div class="container"><p class="src">Sumber: publikasi Distribusi Dana {{ $triwulanLabel($triwulan->triwulan) }} {{ $periode->name }}, DPM UII. Dasar pengaturan: PKM UII No. 3 Tahun 2024 tentang Distribusi dan Alokasi Dana KM UII.</p></div></section>

<script>
  (function () {
    const links = [...document.querySelectorAll('.dd-nav a')], secs = links.map(a => document.querySelector(a.getAttribute('href')));
    function spy() { let c = 0; secs.forEach((s, i) => { if (s.getBoundingClientRect().top < 160) c = i; }); links.forEach((a, i) => a.classList.toggle('on', i === c)); }
    addEventListener('scroll', spy, { passive: true }); spy();
  })();
</script>
@endsection