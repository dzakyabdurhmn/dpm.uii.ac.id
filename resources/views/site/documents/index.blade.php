@extends('layouts.site')

@section('title', ($heading ?? 'Dokumen & laporan').' — '.($siteSettings['site_name'] ?? 'DPM UII'))

@section('content')
    <style>
        .docs-page { color: rgba(255,255,255,.85); }
        .docs-hero { background: #001E43; color: #fff; }
        .docs-wrap { width: min(1180px, calc(100% - 40px)); margin: 0 auto; }
        .docs-hero-inner { padding: 68px 0 64px; }
        .docs-eyebrow { margin: 0 0 10px; color: rgba(255,255,255,.72); font-size: 12px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; }
        .docs-hero h1 { margin: 0; color: #fff; font-size: clamp(30px, 4.6vw, 44px); font-weight: 800; letter-spacing: -.03em; }
        .docs-hero-copy { max-width: 720px; margin: 14px 0 0; color: rgba(255,255,255,.82); font-size: 15px; line-height: 1.85; }
        .docs-section { padding: 48px 0 70px; background: #001E43; }
        .docs-search { display: flex; gap: 12px; margin-bottom: 18px; }
        .docs-search-input { flex: 1; height: 48px; padding: 0 18px 0 48px; border-radius: 8px; border: 1px solid rgba(255,255,255,.18); background: #001A3A; color: #fff; font-size: 14px; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23888' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='7'/%3E%3Cpath d='m21 21-4.3-4.3'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: 14px center; background-size: 20px; }
        .docs-search-input::placeholder { color: rgba(255,255,255,.5); }
        .docs-search-input:focus { outline: none; border-color: rgba(255,255,255,.5); box-shadow: 0 0 0 3px rgba(255,255,255,.1); }
        .docs-search-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 48px; padding: 0 20px; border-radius: 8px; background: linear-gradient(135deg, #1E3A5F 0%, #0D253F 100%); border: 1px solid rgba(255,255,255,.2); color: #fff; font-size: 13px; font-weight: 600; letter-spacing: .02em; transition: all .2s; }
        .docs-search-btn:hover { background: linear-gradient(135deg, #254A7A 0%, #12304F 100%); border-color: rgba(255,255,255,.35); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.2); }
        .docs-search-btn:active { transform: translateY(0); }
        .docs-search-btn svg { width: 18px; height: 18px; stroke: currentColor; }
        .docs-search-btn .btn-text { display: none; }
        @media (min-width: 480px) { .docs-search-btn .btn-text { display: inline; } }
        .docs-list { overflow: hidden; border: 1px solid rgba(255,255,255,.1); border-radius: 8px; background: #001A3A; }
        .docs-list-item { display: flex; flex-wrap: wrap; align-items: center; gap: 16px; padding: 16px 22px; transition: background .15s; }
        .docs-list-item:hover { background: rgba(255,255,255,.03); }
        .docs-list-item + .docs-list-item { border-top: 1px solid rgba(255,255,255,.1); }
        .docs-list-ext { display: grid; place-items: center; width: 48px; height: 48px; border-radius: 6px; background: rgba(255,255,255,.06); color: rgba(255,255,255,.8); font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .12em; }
        .docs-list-ext svg { width: 24px; height: 24px; }
        .docs-list-info { flex: 1; min-width: 0; }
        .docs-list-title { color: #fff; font-size: 14px; font-weight: 800; }
        .docs-list-meta { display: flex; flex-wrap: wrap; gap: 8px 14px; margin-top: 6px; color: rgba(255,255,255,.62); font-size: 11px; }
        .docs-list-meta span + span::before { content: '·'; margin-right: 14px; color: rgba(255,255,255,.38); }
        .docs-list-desc { margin-top: 6px; color: rgba(255,255,255,.72); font-size: 12px; line-height: 1.7; }
        .docs-list-actions { display: flex; align-items: center; gap: 14px; }
        .docs-list-count { color: rgba(255,255,255,.56); font-size: 11px; }
        .docs-list-btn { display: inline-flex; align-items: center; justify-content: center; height: 38px; padding: 0 16px; border-radius: 6px; border: 1px solid rgba(255,255,255,.3); color: #fff; font-size: 12px; font-weight: 700; transition: all .15s; }
        .docs-list-btn:hover { background: rgba(255,255,255,.1); border-color: rgba(255,255,255,.5); }
        .docs-empty { padding: 28px; text-align: center; color: rgba(255,255,255,.72); font-size: 13px; }
        .docs-pagination { margin-top: 32px; display: flex; justify-content: center; }
        .docs-pagination nav { display: flex; gap: 8px; }
        .docs-pagination .page-link { display: inline-flex; align-items: center; justify-content: center; min-width: 38px; height: 38px; padding: 0 12px; border-radius: 6px; border: 1px solid rgba(255,255,255,.18); color: rgba(255,255,255,.8); font-size: 12px; }
        .docs-pagination .page-item.active .page-link { border-color: rgba(255,255,255,.52); color: #fff; }
        @media (max-width: 640px) { .docs-wrap { width: min(100% - 28px, 1180px); } .docs-hero-inner { padding: 48px 0 46px; } .docs-section { padding: 34px 0 52px; } .docs-search { flex-direction: column; } .docs-search-input { padding: 0 18px; background-image: none; } .docs-list-item { padding: 16px; } }
    </style>

    <div class="docs-page">
        <section class="docs-hero">
            <div class="docs-wrap docs-hero-inner">
                <p class="docs-eyebrow">Arsip Resmi</p>
                <h1>{{ $heading ?? 'Dokumen & laporan' }}</h1>
                <p class="docs-hero-copy">{{ $description ?? 'Produk hukum, surat keputusan, laporan keuangan triwulan, dan laporan kinerja DPM UII.' }}</p>
            </div>
        </section>

        <section class="docs-section">
            <div class="docs-wrap">
                <div x-data="documentSearch('{{ url()->current() }}', {{ json_encode($filters) }})" class="docs-search-wrapper">
                    <div class="docs-search" role="search" aria-label="Cari dokumen">
                        <label for="doc-search" class="sr-only">Cari dokumen</label>
                        <input type="search"
                               id="doc-search"
                               name="q"
                               :value="query"
                               @input="debounceSearch($event.target.value)"
                               placeholder="{{ $heading ? 'Cari ' . strtolower($heading) . '…' : 'Cari judul dokumen…' }}"
                               class="docs-search-input"
                               autocomplete="off"
                               aria-describedby="search-hint">
                        <button type="button"
                                @click="performSearch()"
                                class="docs-search-btn"
                                aria-label="Cari">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                            <span class="btn-text">Cari</span>
                        </button>
                    </div>
                    <div x-show="isSearching" class="sr-only" aria-live="polite" id="search-hint">Sedang mencari…</div>

                    <div class="docs-list" x-ref="listContainer">
                        @if ($documents->isEmpty())
                            <div class="docs-empty">Belum ada dokumen.</div>
                        @else
                            @foreach ($documents as $document)
                                <article class="docs-list-item">
                                    <div class="docs-list-ext">{!! $document->extension !!}</div>
                                    <div class="docs-list-info">
                                        <div class="docs-list-title">{{ $document->title }}</div>
                                        <div class="docs-list-meta">
                                            @if ($document->category)<span>{{ $document->category->name }}</span>@endif
                                            @if ($document->year)<span>{{ $document->year }}</span>@endif
                                            @if ($document->quarter_label)<span>{{ $document->quarter_label }}</span>@endif
                                            @if ($document->size > 0)<span>{{ $document->human_size }}</span>@endif
                                        </div>
                                        @if ($document->description)
                                            <p class="docs-list-desc">{{ $document->description }}</p>
                                        @endif
                                    </div>
                                    <div class="docs-list-actions">
                                        <span class="docs-list-count">{{ $document->downloads }} unduhan</span>
                                        <a href="{{ route('documents.download', $document) }}" class="docs-list-btn">{{ $document->isExternal() ? 'Buka tautan' : 'Unduh' }}</a>
                                    </div>
                                </article>
                            @endforeach
                        @endif
                    </div>

                    <div class="docs-pagination" x-ref="paginationContainer">
                        {{ $documents->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function documentSearch(baseUrl, initialFilters) {
            return {
                query: initialFilters.q || '',
                isSearching: false,
                debounceTimer: null,

                debounceSearch(value) {
                    this.query = value;
                    clearTimeout(this.debounceTimer);
                    this.debounceTimer = setTimeout(() => this.performSearch(), 300);
                },

                async performSearch() {
                    this.isSearching = true;
                    const params = new URLSearchParams();

                    if (this.query.trim()) {
                        params.set('q', this.query.trim());
                    }

                    // Preserve other filters from URL
                    const urlParams = new URLSearchParams(window.location.search);
                    ['kategori', 'tahun', 'triwulan', 'periode'].forEach(key => {
                        if (urlParams.has(key)) params.set(key, urlParams.get(key));
                    });

                    const url = `${baseUrl}?${params.toString()}`;

                    try {
                        const response = await fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'text/html'
                            }
                        });

                        if (!response.ok) throw new Error('Network response was not ok');

                        const html = await response.text();
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // Update list
                        const newList = doc.querySelector('.docs-list');
                        if (newList && this.$refs.listContainer) {
                            this.$refs.listContainer.innerHTML = newList.innerHTML;
                        }

                        // Update pagination
                        const newPagination = doc.querySelector('.docs-pagination');
                        if (newPagination && this.$refs.paginationContainer) {
                            this.$refs.paginationContainer.innerHTML = newPagination.innerHTML;
                        }

                        // Update URL without reload
                        window.history.replaceState({}, '', url);
                    } catch (error) {
                        console.error('Search failed:', error);
                        // Fallback: normal form submit
                        window.location.href = url;
                    } finally {
                        this.isSearching = false;
                    }
                }
            }
        }
    </script>
@endsection
