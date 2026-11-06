@extends('layouts.site')

@section('title', ($bioLink->site_name ?? 'Bio Link').' — '.($bioLink->tagline ?? 'DPM UII'))
@section('meta_description', $bioLink->description ?? 'Bio link DPM UII')

@section('content')
<style>
.bio-page { min-height: 100vh; background: #001E43; color: #fff; padding: 40px 16px 60px; }
.bio-wrap { max-width: 460px; margin: 0 auto; }
.bio-header { text-align: center; margin-bottom: 28px; }
.bio-logo { width: 96px; height: 96px; margin: 0 auto 14px; border-radius: 50%; background: #002A5C; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 3px solid rgba(255,255,255,.15); }
.bio-logo img { width: 100%; height: 100%; object-fit: cover; }
.bio-name { font-size: 22px; font-weight: 800; margin: 0 0 4px; letter-spacing: -.02em; }
.bio-handle { color: rgba(255,255,255,.7); font-size: 14px; margin: 0 0 10px; }
.bio-desc { color: rgba(255,255,255,.78); font-size: 14px; line-height: 1.6; margin: 0; }
.bio-socials { display: flex; justify-content: center; gap: 12px; margin: 18px 0 8px; }
.bio-socials a { width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,.08); display: flex; align-items: center; justify-content: center; color: #fff; transition: background .2s; }
.bio-socials a:hover { background: rgba(255,255,255,.18); }
.bio-socials svg { width: 16px; height: 16px; fill: currentColor; }
.bio-feature { margin: 24px 0; border-radius: 12px; background: linear-gradient(135deg, rgba(255,255,255,.1), rgba(255,255,255,.03)); border: 1px solid rgba(255,255,255,.12); padding: 18px; }
.bio-feature .eyebrow { font-size: 11px; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: rgba(255,255,255,.7); margin: 0 0 6px; }
.bio-feature .title { font-size: 16px; font-weight: 800; margin: 0 0 6px; }
.bio-feature .desc { font-size: 13px; color: rgba(255,255,255,.78); margin: 0 0 12px; line-height: 1.5; }
.bio-feature .btn { display: inline-flex; align-items: center; gap: 6px; height: 36px; padding: 0 16px; border-radius: 8px; background: #fff; color: #001E43; font-size: 13px; font-weight: 700; text-decoration: none; }
.bio-group { margin: 20px 0; }
.bio-group-title { font-size: 12px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; color: rgba(255,255,255,.6); margin: 0 0 10px; text-align: center; }
.bio-item { display: flex; align-items: center; gap: 12px; padding: 14px 16px; margin: 8px 0; border-radius: 10px; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1); color: #fff; text-decoration: none; transition: background .2s, transform .15s; }
.bio-item:hover { background: rgba(255,255,255,.12); transform: translateY(-1px); }
.bio-item .icon { width: 36px; height: 36px; border-radius: 8px; background: rgba(255,255,255,.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.bio-item .icon svg, .bio-item .icon i { width: 20px; height: 20px; }
.bio-item .meta { flex: 1; min-width: 0; }
.bio-item .title { font-size: 14px; font-weight: 700; margin: 0; }
.bio-item .desc { font-size: 12px; color: rgba(255,255,255,.65); margin: 2px 0 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.bio-footer { text-align: center; margin-top: 32px; color: rgba(255,255,255,.45); font-size: 12px; }
</style>

<div class="bio-page">
    <div class="bio-wrap">
        <header class="bio-header">
            <div class="bio-logo">
                @if($bioLink->logo)
                    <img src="{{ $bioLink->logo }}" alt="{{ $bioLink->site_name }}">
                @else
                    <span style="font-size:32px;font-weight:800;">{{ strtoupper(substr($bioLink->site_name ?? 'D', 0, 1)) }}</span>
                @endif
            </div>
            <h1 class="bio-name">{{ $bioLink->site_name }}</h1>
            @if($bioLink->handle)
                <p class="bio-handle">{{ $bioLink->handle }}</p>
            @endif
            @if($bioLink->description)
                <p class="bio-desc">{{ $bioLink->description }}</p>
            @endif

            @if(is_array($bioLink->social_links) && count($bioLink->social_links))
                <div class="bio-socials">
                    @foreach($bioLink->social_links as $social)
                        @if(!empty($social['url']))
                            <a href="{{ $social['url'] }}" target="_blank" rel="noopener" aria-label="{{ $social['label'] ?? 'Social' }}">
                                @if (! empty($social['svg']))
                                    {!! $social['svg'] !!}
                                @else
                                    <i class="{{ $social['icon'] ?? 'fa-solid fa-link' }}"></i>
                                @endif
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
        </header>

        @foreach($bioLink->activeFeatures as $feature)
            <div class="bio-feature">
                @if($feature->eyebrow)<p class="eyebrow">{{ $feature->eyebrow }}</p>@endif
                <p class="title">{{ $feature->title }}</p>
                @if($feature->description)<p class="desc">{{ $feature->description }}</p>@endif
                @if($feature->button_url)
                    <a class="btn" href="{{ $feature->button_url }}" target="_blank" rel="noopener">
                        {{ $feature->button_text ?? 'Selengkapnya' }}
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                @endif
            </div>
        @endforeach

        @foreach($bioLink->activeGroups as $group)
            <div class="bio-group">
                @if($group->title)<p class="bio-group-title">{{ $group->title }}</p>@endif
                @foreach($group->activeItems as $item)
                    <a class="bio-item" href="{{ $item->url }}" @if($item->open_in_new_tab) target="_blank" rel="noopener" @endif>
                        <span class="icon">
                            @if($item->icon_type === 'custom' && $item->icon)
                                {!! $item->icon !!}
                            @elseif($item->icon)
                                <i class="fa-solid fa-{{ $item->icon }}"></i>
                            @else
                                <i class="fa-solid fa-link"></i>
                            @endif
                        </span>
                        <span class="meta">
                            <p class="title">{{ $item->title }}</p>
                            @if($item->description)<p class="desc">{{ $item->description }}</p>@endif
                        </span>
                        <i class="fa-solid fa-chevron-right" style="opacity:.5;font-size:12px;"></i>
                    </a>
                @endforeach
            </div>
        @endforeach

        @if($bioLink->address || $bioLink->email || $bioLink->phone)
            <div class="bio-footer">
                @if($bioLink->address)<p>{{ $bioLink->address }}</p>@endif
                @if($bioLink->email)<p><a href="mailto:{{ $bioLink->email }}" style="color:inherit;">{{ $bioLink->email }}</a></p>@endif
                @if($bioLink->phone)<p>{{ $bioLink->phone }}</p>@endif
            </div>
        @endif
    </div>
</div>
@endsection