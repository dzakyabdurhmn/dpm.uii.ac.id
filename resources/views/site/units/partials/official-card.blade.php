<article class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
    @if ($official->photo_url)
        <img src="{{ $official->photo_url }}" alt="{{ $official->name }}"
             class="h-72 w-full object-cover" loading="lazy">
    @else
        <div class="flex h-72 w-full items-center justify-center bg-brand-50 text-4xl font-bold text-brand-700">
            {{ \Illuminate\Support\Str::substr($official->name, 0, 1) }}
        </div>
    @endif

    <div class="p-5">
        <p class="text-base font-bold text-slate-900">{{ $official->name }}</p>

        @if ($official->description)
            <p class="mt-1 text-sm leading-relaxed text-slate-600">{{ $official->description }}</p>
        @endif

        @if ($official->position)
            <p class="mt-1 text-xs font-medium text-slate-500">{{ $official->position }}</p>
        @endif

        @if ($official->email)
            <a href="mailto:{{ $official->email }}" class="mt-2 inline-block text-xs text-brand-700 hover:underline">
                {{ $official->email }}
            </a>
        @endif
    </div>
</article>
