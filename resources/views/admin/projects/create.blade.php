@extends('layouts.admin')

@section('title', 'Tambah Project')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Tambah Project</h1>
            <p class="text-sm text-slate-400">Tambahkan proyek baru lengkap dengan thumbnail dan tautan repositori.</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="text-xs font-medium text-slate-400 hover:text-white transition">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 rounded-2xl border border-slate-800 bg-slate-900/70 p-6">
        @csrf

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="title" class="block text-xs font-medium text-slate-300 mb-1.5">
                    Judul Project <span class="text-rose-400">*</span>
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
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
                    value="{{ old('category') }}"
                    placeholder="Contoh: Web, Mobile, Data/AI"
                    required
                    class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2 text-sm text-white placeholder-slate-500 focus:border-emerald-500 focus:outline-none"
                >
                @error('category')
                    <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="slug" class="block text-xs font-medium text-slate-300 mb-1.5">
                    Slug (Opsional)
                </label>
                <input
                    type="text"
                    id="slug"
                    name="slug"
                    value="{{ old('slug') }}"
                    placeholder="Otomatis dari judul jika dikosongkan"
                    class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2 text-sm text-white placeholder-slate-500 focus:border-emerald-500 focus:outline-none"
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
                    value="{{ old('sort_order', 0) }}"
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
            >{{ old('summary') }}</textarea>
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
            >{{ old('content') }}</textarea>
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
                value="{{ old('tech_stack') }}"
                placeholder="Laravel, MySQL, Tailwind CSS, Alpine.js"
                class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2 text-sm text-white placeholder-slate-500 focus:border-emerald-500 focus:outline-none"
            >
            @error('tech_stack')
                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Upload Thumbnail + Preview Alpine.js --}}
        <div x-data="{ previewUrl: '' }" class="space-y-2">
            <label for="thumbnail" class="block text-xs font-medium text-slate-300">
                Thumbnail Project (JPG, PNG, WEBP — maks. 2 MB)
            </label>
            <input
                type="file"
                id="thumbnail"
                name="thumbnail"
                accept="image/jpeg,image/png,image/webp"
                @change="
                    const file = $event.target.files[0];
                    previewUrl = file ? URL.createObjectURL(file) : '';
                "
                class="block w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-xs text-slate-300 file:mr-4 file:rounded-md file:border-0 file:bg-emerald-500/15 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-emerald-300 hover:file:bg-emerald-500/25"
            >
            @error('thumbnail')
                <p class="text-xs text-rose-400">{{ $message }}</p>
            @enderror

            <template x-if="previewUrl">
                <div class="pt-2">
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
                    value="{{ old('github_url') }}"
                    placeholder="https://github.com/MakotoAi/nama-repo"
                    class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2 text-sm text-white placeholder-slate-500 focus:border-emerald-500 focus:outline-none"
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
                    value="{{ old('demo_url') }}"
                    placeholder="https://example.com"
                    class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2 text-sm text-white placeholder-slate-500 focus:border-emerald-500 focus:outline-none"
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
                @checked(old('is_featured'))
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
                Simpan Project
            </button>
        </div>
    </form>
</div>
@endsection
