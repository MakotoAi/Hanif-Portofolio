@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $initialThumb = '';
    if ($project->thumbnail) {
        $initialThumb = Str::startsWith($project->thumbnail, ['http://', 'https://'])
            ? $project->thumbnail
            : Storage::url($project->thumbnail);
    }

    $techString = is_array($project->tech_stack)
        ? implode(', ', $project->tech_stack)
        : (string) $project->tech_stack;
@endphp

@extends('layouts.admin')

@section('title', 'Edit Project')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Edit Project</h1>
            <p class="text-sm text-slate-400">{{ $project->title }}</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="text-xs font-medium text-slate-400 hover:text-white transition">
            &larr; Kembali
        </a>
    </div>

    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-5 rounded-2xl border border-slate-800 bg-slate-900/70 p-6">
        @csrf
        @method('PUT')

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="title" class="block text-xs font-medium text-slate-300 mb-1.5">
                    Judul Project <span class="text-rose-400">*</span>
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $project->title) }}"
                    required
                    class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2 text-sm text-white focus:border-emerald-500 focus:outline-none"
                >
                @error('title')
                    <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category" class="block text-xs font-medium text-slate-300 mb-1.5">
                    Kategori <span class="text-rose-400">*</span>
                </label>
                <input
                    type="text"
                    id="category"
                    name="category"
                    value="{{ old('category', $project->category) }}"
                    required
                    class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2 text-sm text-white focus:border-emerald-500 focus:outline-none"
                >
                @error('category')
                    <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="slug" class="block text-xs font-medium text-slate-300 mb-1.5">
                    Slug
                </label>
                <input
                    type="text"
                    id="slug"
                    name="slug"
                    value="{{ old('slug', $project->slug) }}"
                    class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2 text-sm text-white focus:border-emerald-500 focus:outline-none"
                >
                @error('slug')
                    <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="sort_order" class="block text-xs font-medium text-slate-300 mb-1.5">
                    Urutan Tampil
                </label>
                <input
                    type="number"
                    id="sort_order"
                    name="sort_order"
                    value="{{ old('sort_order', $project->sort_order ?? 0) }}"
                    min="0"
                    class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2 text-sm text-white focus:border-emerald-500 focus:outline-none"
                >
                @error('sort_order')
                    <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="summary" class="block text-xs font-medium text-slate-300 mb-1.5">
                Ringkasan Singkat <span class="text-rose-400">*</span>
            </label>
            <textarea
                id="summary"
                name="summary"
                rows="2"
                required
                class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2 text-sm text-white focus:border-emerald-500 focus:outline-none"
            >{{ old('summary', $project->summary) }}</textarea>
            @error('summary')
                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="content" class="block text-xs font-medium text-slate-300 mb-1.5">
                Detail Case Study
            </label>
            <textarea
                id="content"
                name="content"
                rows="5"
                class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2 text-sm text-white focus:border-emerald-500 focus:outline-none"
            >{{ old('content', $project->content) }}</textarea>
            @error('content')
                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="tech_stack" class="block text-xs font-medium text-slate-300 mb-1.5">
                Tech Stack (pisahkan dengan koma)
            </label>
            <input
                type="text"
                id="tech_stack"
                name="tech_stack"
                value="{{ old('tech_stack', $techString) }}"
                class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2 text-sm text-white focus:border-emerald-500 focus:outline-none"
            >
            @error('tech_stack')
                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Upload Thumbnail Baru + Preview Alpine.js --}}
        <div x-data="{ previewUrl: '{{ e($initialThumb) }}' }" class="space-y-2">
            <label for="thumbnail" class="block text-xs font-medium text-slate-300">
                Ganti Thumbnail Project (JPG, PNG, WEBP — maks. 2 MB)
            </label>
            <input
                type="file"
                id="thumbnail"
                name="thumbnail"
                accept="image/jpeg,image/png,image/webp"
                @change="
                    const file = $event.target.files[0];
                    if (file) {
                        previewUrl = URL.createObjectURL(file);
                    }
                "
                class="block w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-xs text-slate-300 file:mr-4 file:rounded-md file:border-0 file:bg-emerald-500/15 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-emerald-300 hover:file:bg-emerald-500/25"
            >
            @error('thumbnail')
                <p class="text-xs text-rose-400">{{ $message }}</p>
            @enderror

            <template x-if="previewUrl">
                <div class="pt-2">
                    <p class="mb-1.5 text-[11px] text-slate-400">Preview thumbnail aktif:</p>
                    <img :src="previewUrl" alt="Preview Thumbnail" class="h-40 w-full max-w-xs rounded-xl border border-slate-800 object-cover">
                </div>
            </template>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="github_url" class="block text-xs font-medium text-slate-300 mb-1.5">
                    GitHub URL
                </label>
                <input
                    type="url"
                    id="github_url"
                    name="github_url"
                    value="{{ old('github_url', $project->github_url) }}"
                    class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2 text-sm text-white focus:border-emerald-500 focus:outline-none"
                >
                @error('github_url')
                    <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="demo_url" class="block text-xs font-medium text-slate-300 mb-1.5">
                    Demo URL
                </label>
                <input
                    type="url"
                    id="demo_url"
                    name="demo_url"
                    value="{{ old('demo_url', $project->demo_url) }}"
                    class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2 text-sm text-white focus:border-emerald-500 focus:outline-none"
                >
                @error('demo_url')
                    <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-2 pt-1">
            <input
                type="checkbox"
                id="is_featured"
                name="is_featured"
                value="1"
                @checked(old('is_featured', $project->is_featured))
                class="h-4 w-4 rounded border-slate-700 bg-slate-950 text-emerald-500 focus:ring-emerald-500"
            >
            <label for="is_featured" class="text-xs font-medium text-slate-300">
                Tandai sebagai Featured Project
            </label>
        </div>

        <div class="flex items-center justify-end gap-3 border-t border-slate-800 pt-5">
            <a href="{{ route('admin.projects.index') }}" class="rounded-lg border border-slate-700 px-4 py-2 text-xs font-medium text-slate-300 hover:bg-slate-800 transition">
                Batal
            </a>
            <button type="submit" class="rounded-lg bg-emerald-500 px-5 py-2 text-xs font-semibold text-slate-950 hover:bg-emerald-400 transition">
                Update Project
            </button>
        </div>
    </form>
</div>
@endsection
