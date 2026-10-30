@if ($documents->isEmpty())
    <div class="docs-empty">Belum ada dokumen pada filter ini.</div>
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

<div class="docs-pagination">
    {{ $documents->links() }}
</div>