@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $thumbnailUrl = null;
    if ($project->thumbnail) {
        $thumbnailUrl = Str::startsWith($project->thumbnail, ['http://', 'https://'])
            ? $project->thumbnail
            : Storage::url($project->thumbnail);
    }

    $absoluteThumbnailUrl = $thumbnailUrl
        ? (Str::startsWith($thumbnailUrl, ['http://', 'https://']) ? $thumbnailUrl : url($thumbnailUrl))
        : null;
@endphp

@extends('layouts.portfolio')

@section('title', $project->title . ' — Ahmad Hanif')
@section('meta_description', Str::limit(strip_tags($project->summary), 160))
@section('og_type', 'article')
@if($absoluteThumbnailUrl)
    @section('og_image', $absoluteThumbnailUrl)
@endif

@section('content')
<section class="mx-auto max-w-4xl px-4 py-12 sm:px-6 sm:py-16">
    <div class="mb-8">
        <a href="{{ route('portfolio.index') }}#projects" class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-400 hover:text-emerald-400 transition">
            <span>←</span>
            <span>Kembali ke Daftar Projects</span>
        </a>
    </div>

    <article class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6 sm:p-10">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2.5 text-xs">
                <span class="rounded-md border border-cyan-500/20 bg-cyan-500/10 px-2.5 py-1 font-semibold uppercase tracking-wide text-cyan-300">
                    {{ $project->category }}
                </span>

                @if($project->is_featured)
                    <span class="rounded-md border border-emerald-500/30 bg-emerald-500/10 px-2.5 py-1 font-medium text-emerald-300">
                        Featured Project
                    </span>
                @endif
            </div>

            @if($project->github_stats)
                <div class="flex flex-wrap items-center gap-4 rounded-lg border border-slate-800 bg-slate-950/80 px-3.5 py-1.5 text-xs text-slate-300">
                    @if(!empty($project->github_stats['language']))
                        <span class="inline-flex items-center gap-1.5 font-medium text-cyan-300">
                            <span class="h-2 w-2 rounded-full bg-cyan-400"></span>
                            {{ $project->github_stats['language'] }}
                        </span>
                    @endif

                    <span class="inline-flex items-center gap-1 font-medium text-amber-300">
                        <span>★</span>
                        <span>{{ $project->github_stats['stars'] ?? 0 }}</span>
                        <span class="text-slate-500 font-normal">stars</span>
                    </span>

                    @if(isset($project->github_stats['forks']))
                        <span class="inline-flex items-center gap-1 text-slate-400">
                            <span>Forks:</span>
                            <span class="font-medium text-slate-200">{{ $project->github_stats['forks'] }}</span>
                        </span>
                    @endif
                </div>
            @endif
        </div>

        <h1 class="mt-6 text-2xl font-bold tracking-tight text-white sm:text-4xl">
            {{ $project->title }}
        </h1>

        <p class="mt-4 text-base leading-relaxed text-slate-300">
            {{ $project->summary }}
        </p>

        @if($thumbnailUrl)
            <div class="mt-7 overflow-hidden rounded-2xl border border-slate-800 bg-slate-950">
                <img
                    src="{{ $thumbnailUrl }}"
                    alt="{{ $project->title }}"
                    class="max-h-[440px] w-full object-cover"
                >
            </div>
        @endif

        @if(!empty($project->tech_stack))
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach($project->tech_stack as $tech)
                    <span class="rounded-md border border-slate-800 bg-slate-950 px-3 py-1 text-xs font-medium text-slate-300">
                        {{ $tech }}
                    </span>
                @endforeach
            </div>
        @endif

        @if($project->github_url || $project->demo_url)
            <div class="mt-7 flex flex-wrap items-center gap-3 border-y border-slate-800/80 py-5">
                @if($project->github_url)
                    <a
                        href="{{ $project->github_url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 rounded-lg border border-slate-700 bg-slate-800/90 px-4 py-2 text-xs font-semibold text-white hover:border-emerald-500/50 hover:bg-slate-800 transition"
                    >
                        <span>Lihat di GitHub</span>
                        <span>↗</span>
                    </a>
                @endif

                @if($project->demo_url)
                    <a
                        href="{{ $project->demo_url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 rounded-lg bg-emerald-500 px-4 py-2 text-xs font-semibold text-slate-950 hover:bg-emerald-400 transition"
                    >
                        <span>Live Demo</span>
                        <span>↗</span>
                    </a>
                @endif
            </div>
        @endif

        <div class="mt-8 space-y-4 text-sm leading-relaxed text-slate-300 sm:text-base">
            @if(!empty($project->content))
                <div class="whitespace-pre-line">
                    {{ $project->content }}
                </div>
            @else
                <p class="text-slate-400 italic">
                    Catatan teknis dan dokumentasi lengkap untuk proyek ini belum ditambahkan.
                </p>
            @endif
        </div>
    </article>
</section>
@endsection
