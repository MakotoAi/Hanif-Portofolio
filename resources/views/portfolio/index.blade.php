@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp

@extends('layouts.portfolio')

@section('content')
{{-- Hero Section --}}
<section class="mx-auto max-w-6xl px-4 pt-16 pb-20 sm:px-6 sm:pt-24">
    <div class="max-w-3xl space-y-6">
        <div class="inline-flex items-center gap-2 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-3.5 py-1 text-xs font-medium text-emerald-300">
            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
            Full-Stack Web & Android Developer
        </div>

        <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-6xl">
            Ahmad Hanif
        </h1>

        <p class="text-base leading-relaxed text-slate-300 sm:text-lg">
            Mahasiswa Teknik Informatika yang membangun aplikasi web berbasis Laravel/PHP dan aplikasi Android terintegrasi REST API. Fokus pada struktur database yang rapi, kode yang terukur, dan solusi sistem informasi yang aplikatif.
        </p>

        <div class="flex flex-wrap items-center gap-4 pt-2">
            <a href="#projects" class="rounded-lg bg-emerald-500 px-5 py-2.5 text-sm font-semibold text-slate-950 hover:bg-emerald-400 transition">
                Lihat Proyek
            </a>
            <a href="#contact" class="rounded-lg border border-slate-700 bg-slate-900 px-5 py-2.5 text-sm font-semibold text-slate-200 hover:border-cyan-400/50 hover:text-cyan-300 transition">
                Hubungi Saya
            </a>
            <a href="https://github.com/MakotoAi" target="_blank" rel="noopener noreferrer" class="text-sm font-medium text-slate-400 hover:text-white transition">
                GitHub →
            </a>
        </div>
    </div>
</section>

{{-- Tech Stack & Skills --}}
<section id="skills" class="mx-auto max-w-6xl px-4 py-16 sm:px-6 border-t border-slate-900">
    <div class="mb-8">
        <p class="text-xs font-semibold uppercase tracking-widest text-emerald-400">Tech Stack</p>
        <h2 class="mt-1 text-2xl font-bold text-white sm:text-3xl">Keahlian & Perangkat</h2>
    </div>

    @if($skillsByCategory->isEmpty())
        <p class="text-sm text-slate-400">Belum ada data skill tersimpan.</p>
    @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($skillsByCategory as $category => $items)
                <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-5">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-cyan-400">
                        {{ $category }}
                    </h3>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($items as $skill)
                            <span class="rounded-md border border-slate-700/80 bg-slate-950 px-3 py-1 text-xs font-medium text-slate-200">
                                {{ $skill->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>

{{-- Filterable Project Grid --}}
<section id="projects" x-data="{ activeCategory: 'all' }" class="mx-auto max-w-6xl px-4 py-16 sm:px-6 border-t border-slate-900">
    <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <span class="text-xs font-semibold uppercase tracking-wider text-emerald-400">Projects</span>
            <h2 class="mt-2 text-2xl font-bold text-white sm:text-3xl">Karya & Repositori</h2>
            <p class="mt-2 text-sm text-slate-400">
                Pilih kategori di bawah untuk menyaring proyek berdasarkan bidang pengembangan.
            </p>
        </div>

        {{-- Tombol Filter Kategori --}}
        @php
            $categories = collect($projects ?? [])
                ->pluck('category')
                ->filter()
                ->map(fn ($cat) => strtolower(trim($cat)))
                ->unique()
                ->values();
        @endphp

        <div class="flex flex-wrap gap-2">
            <button
                type="button"
                @click="activeCategory = 'all'"
                :class="activeCategory === 'all'
                    ? 'bg-emerald-500 text-slate-950 border-emerald-500'
                    : 'bg-slate-900/70 text-slate-300 border-slate-800 hover:border-slate-700 hover:text-white'"
                class="rounded-lg border px-3.5 py-1.5 text-xs font-semibold transition"
            >
                Semua
            </button>

            @foreach($categories as $category)
                <button
                    type="button"
                    @click="activeCategory = '{{ e($category) }}'"
                    :class="activeCategory === '{{ e($category) }}'
                        ? 'bg-emerald-500 text-slate-950 border-emerald-500'
                        : 'bg-slate-900/70 text-slate-300 border-slate-800 hover:border-slate-700 hover:text-white'"
                    class="rounded-lg border px-3.5 py-1.5 text-xs font-semibold capitalize transition"
                >
                    {{ $category }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Grid Daftar Proyek --}}
    @if(($projects ?? collect())->isEmpty())
        <div class="mt-8 rounded-2xl border border-slate-800 bg-slate-900/60 p-8 text-center text-sm text-slate-400">
            Belum ada data proyek yang ditambahkan.
        </div>
    @else
        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($projects as $project)
                @php
                    $projectCategory = strtolower(trim($project->category ?? 'lainnya'));
                    $thumbnailUrl = null;
                    if ($project->thumbnail) {
                        $thumbnailUrl = Str::startsWith($project->thumbnail, ['http://', 'https://'])
                            ? $project->thumbnail
                            : Storage::url($project->thumbnail);
                    }
                @endphp

                <article
                    data-category="{{ e($projectCategory) }}"
                    x-show="activeCategory === 'all' || activeCategory === '{{ e($projectCategory) }}'"
                    x-transition.opacity.duration.200ms
                    class="flex flex-col justify-between rounded-2xl border border-slate-800 bg-slate-900/60 p-6 transition hover:border-slate-700"
                >
                    <div>
                        @if($thumbnailUrl)
                            <a href="{{ route('portfolio.show', $project->slug) }}" class="mb-4 block overflow-hidden rounded-xl border border-slate-800 bg-slate-950">
                                <img
                                    src="{{ $thumbnailUrl }}"
                                    alt="{{ $project->title }}"
                                    class="h-44 w-full object-cover transition duration-300 hover:scale-105"
                                    loading="lazy"
                                >
                            </a>
                        @endif

                        <div class="flex items-center justify-between gap-2">
                            <span class="rounded-md border border-cyan-500/20 bg-cyan-500/10 px-2.5 py-0.5 text-[11px] font-semibold uppercase tracking-wide text-cyan-300">
                                {{ $project->category }}
                            </span>

                            @if(!empty($project->github_stats['stars']))
                                <span class="text-xs font-medium text-amber-300">
                                    ★ {{ $project->github_stats['stars'] }}
                                </span>
                            @endif
                        </div>

                        <h3 class="mt-4 text-lg font-bold text-white">
                            <a href="{{ route('portfolio.show', $project->slug) }}" class="hover:text-emerald-400 transition">
                                {{ $project->title }}
                            </a>
                        </h3>

                        <p class="mt-2 text-sm leading-relaxed text-slate-400">
                            {{ $project->summary }}
                        </p>

                        @if(!empty($project->tech_stack))
                            <div class="mt-4 flex flex-wrap gap-1.5">
                                @foreach($project->tech_stack as $tech)
                                    <span class="rounded border border-slate-800 bg-slate-950 px-2 py-0.5 text-[11px] text-slate-300">
                                        {{ $tech }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 flex items-center justify-between border-t border-slate-800/80 pt-4 text-xs">
                        <a href="{{ route('portfolio.show', $project->slug) }}" class="font-semibold text-emerald-400 hover:underline">
                            Detail Proyek →
                        </a>

                        @if($project->github_url)
                            <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white transition">
                                GitHub ↗
                            </a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Pesan Jika Kategori Aktif Tidak Memiliki Proyek --}}
        <div
            x-show="activeCategory !== 'all' && !document.querySelector('#projects article[data-category=\'' + activeCategory + '\']')"
            x-cloak
            class="mt-8 rounded-2xl border border-slate-800 bg-slate-900/60 p-8 text-center text-sm text-slate-400"
        >
            Tidak ada proyek pada kategori ini.
        </div>
    @endif
</section>

{{-- Experience & Education --}}
<section id="experience" class="mx-auto max-w-6xl px-4 py-16 sm:px-6 border-t border-slate-900">
    <div class="mb-8">
        <p class="text-xs font-semibold uppercase tracking-widest text-emerald-400">Journey</p>
        <h2 class="mt-1 text-2xl font-bold text-white sm:text-3xl">Pendidikan & Pengalaman</h2>
    </div>

    @if($experiences->isEmpty())
        <p class="text-sm text-slate-400">Belum ada data pengalaman.</p>
    @else
        <div class="space-y-6 border-l border-slate-800 ml-2 pl-6">
            @foreach($experiences as $exp)
                <div class="relative rounded-xl border border-slate-800 bg-slate-900/50 p-5">
                    <span class="absolute -left-[31px] top-6 h-3 w-3 rounded-full border-2 border-slate-950 bg-emerald-400"></span>

                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div>
                            <h3 class="text-base font-bold text-white">{{ $exp->role }}</h3>
                            <p class="text-sm text-cyan-400">
                                {{ $exp->organization }}
                                @if($exp->location)
                                    <span class="text-slate-400"> • {{ $exp->location }}</span>
                                @endif
                            </p>
                        </div>

                        <span class="rounded-md bg-slate-950 border border-slate-800 px-2.5 py-1 text-xs text-slate-300">
                            {{ $exp->start_date?->format('M Y') }} —
                            {{ $exp->is_current ? 'Present' : ($exp->end_date?->format('M Y') ?? '-') }}
                        </span>
                    </div>

                    @if($exp->description)
                        <p class="mt-3 text-sm leading-relaxed text-slate-300">
                            {{ $exp->description }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</section>

{{-- Contact Form --}}
<section id="contact" class="mx-auto max-w-4xl px-4 py-16 sm:px-6">
    <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6 sm:p-10">
        <div class="max-w-xl">
            <span class="text-xs font-semibold uppercase tracking-wider text-emerald-400">Kontak</span>
            <h2 class="mt-2 text-2xl font-bold text-white sm:text-3xl">Mari Berkolaborasi</h2>
            <p class="mt-2 text-sm leading-relaxed text-slate-400">
                Punya tawaran proyek web, aplikasi mobile, atau sekadar ingin berdiskusi? Kirim pesan langsung lewat form di bawah ini.
            </p>
        </div>

        {{-- Notifikasi Sukses --}}
        @if(session('contact_status'))
            <div class="mt-6 rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3.5 text-sm text-emerald-300">
                {{ session('contact_status') }}
            </div>
        @endif

        {{-- Notifikasi Error Umum --}}
        @if($errors->any())
            <div class="mt-6 rounded-xl border border-rose-500/40 bg-rose-500/10 px-4 py-3.5 text-sm text-rose-300">
                Mohon periksa kembali isian form yang ditandai merah di bawah ini.
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST" class="mt-8 space-y-5">
            @csrf

            {{-- Honeypot anti-spam (tersembunyi dari pengguna manusia) --}}
            <div class="hidden" aria-hidden="true">
                <input type="text" name="website" tabindex="-1" autocomplete="off">
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="sender_name" class="block text-xs font-medium text-slate-300 mb-1.5">
                        Nama Lengkap <span class="text-rose-400">*</span>
                    </label>
                    <input
                        type="text"
                        id="sender_name"
                        name="sender_name"
                        value="{{ old('sender_name') }}"
                        placeholder="Masukkan nama kamu"
                        required
                        class="w-full rounded-lg border {{ $errors->has('sender_name') ? 'border-rose-500' : 'border-slate-700' }} bg-slate-950 px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:border-emerald-500 focus:outline-none"
                    >
                    @error('sender_name')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sender_email" class="block text-xs font-medium text-slate-300 mb-1.5">
                        Email <span class="text-rose-400">*</span>
                    </label>
                    <input
                        type="email"
                        id="sender_email"
                        name="sender_email"
                        value="{{ old('sender_email') }}"
                        placeholder="nama@email.com"
                        required
                        class="w-full rounded-lg border {{ $errors->has('sender_email') ? 'border-rose-500' : 'border-slate-700' }} bg-slate-950 px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:border-emerald-500 focus:outline-none"
                    >
                    @error('sender_email')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="subject" class="block text-xs font-medium text-slate-300 mb-1.5">
                    Subjek
                </label>
                <input
                    type="text"
                    id="subject"
                    name="subject"
                    value="{{ old('subject') }}"
                    placeholder="Contoh: Tawaran Pembuatan Aplikasi Web"
                    class="w-full rounded-lg border {{ $errors->has('subject') ? 'border-rose-500' : 'border-slate-700' }} bg-slate-950 px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:border-emerald-500 focus:outline-none"
                >
                @error('subject')
                    <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="body" class="block text-xs font-medium text-slate-300 mb-1.5">
                    Pesan <span class="text-rose-400">*</span>
                </label>
                <textarea
                    id="body"
                    name="body"
                    rows="5"
                    placeholder="Tuliskan detail kebutuhan atau pesan kamu di sini..."
                    required
                    class="w-full rounded-lg border {{ $errors->has('body') ? 'border-rose-500' : 'border-slate-700' }} bg-slate-950 px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:border-emerald-500 focus:outline-none"
                >{{ old('body') }}</textarea>
                @error('body')
                    <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-1">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-emerald-500 px-6 py-2.5 text-sm font-semibold text-slate-950 hover:bg-emerald-400 transition"
                >
                    Kirim Pesan
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
