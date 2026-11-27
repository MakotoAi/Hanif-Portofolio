<!DOCTYPE html>
<html lang="id" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ahmad Hanif — Full-Stack Web & Android Developer')</title>

    {{-- Meta SEO Dasar --}}
    <meta name="description" content="@yield('meta_description', 'Portofolio Ahmad Hanif — Mahasiswa Teknik Informatika dan pengembang aplikasi web Laravel/PHP serta Android terintegrasi REST API.')">
    <meta name="author" content="Ahmad Hanif">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph (WhatsApp, LinkedIn, Facebook) --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="hanif.dev">
    <meta property="og:title" content="@yield('title', 'Ahmad Hanif — Full-Stack Web & Android Developer')">
    <meta property="og:description" content="@yield('meta_description', 'Portofolio Ahmad Hanif — Mahasiswa Teknik Informatika dan pengembang aplikasi web Laravel/PHP serta Android terintegrasi REST API.')">
    <meta property="og:url" content="{{ url()->current() }}">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="@hasSection('og_image') summary_large_image @else summary @endif">
    <meta name="twitter:title" content="@yield('title', 'Ahmad Hanif — Full-Stack Web & Android Developer')">
    <meta name="twitter:description" content="@yield('meta_description', 'Portofolio Ahmad Hanif — Mahasiswa Teknik Informatika dan pengembang aplikasi web Laravel/PHP serta Android terintegrasi REST API.')">
    @hasSection('og_image')
        <meta name="twitter:image" content="@yield('og_image')">
    @endif

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 antialiased selection:bg-emerald-500/30 selection:text-emerald-200">
    <header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-40 border-b border-slate-800/80 bg-slate-950/85 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6">
            {{-- Brand / Logo --}}
            <a href="{{ route('portfolio.index') }}" class="text-base font-bold tracking-tight text-white">
                hanif<span class="text-emerald-400">.dev</span>
            </a>

            {{-- Navigasi Desktop --}}
            <nav class="hidden items-center gap-6 text-sm font-medium text-slate-300 md:flex">
                <a href="{{ route('portfolio.index') }}#about" class="hover:text-emerald-400 transition">Tentang</a>
                <a href="{{ route('portfolio.index') }}#skills" class="hover:text-emerald-400 transition">Skills</a>
                <a href="{{ route('portfolio.index') }}#projects" class="hover:text-emerald-400 transition">Projects</a>
                <a href="{{ route('portfolio.index') }}#experience" class="hover:text-emerald-400 transition">Pengalaman</a>
                <a href="{{ route('portfolio.index') }}#contact" class="rounded-lg bg-emerald-500 px-3.5 py-2 text-xs font-semibold text-slate-950 hover:bg-emerald-400 transition">
                    Kontak
                </a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-cyan-500/40 bg-cyan-500/10 px-3 py-1.5 text-xs font-semibold text-cyan-300 hover:bg-cyan-500/20 transition">
                        Admin
                    </a>
                @endauth
            </nav>

            {{-- Tombol Hamburger Mobile --}}
            <button
                type="button"
                @click="mobileMenuOpen = !mobileMenuOpen"
                :aria-expanded="mobileMenuOpen.toString()"
                aria-label="Buka atau tutup menu navigasi"
                class="inline-flex items-center justify-center rounded-lg border border-slate-800 bg-slate-900 p-2 text-slate-300 hover:border-slate-700 hover:text-white focus:outline-none md:hidden"
            >
                <svg x-show="!mobileMenuOpen" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="mobileMenuOpen" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Dropdown Menu Mobile --}}
        <div
            x-show="mobileMenuOpen"
            x-transition
            x-cloak
            @click.outside="mobileMenuOpen = false"
            class="border-t border-slate-800/80 bg-slate-900/95 px-4 py-4 md:hidden"
        >
            <nav class="flex flex-col space-y-2 text-sm font-medium text-slate-300">
                <a
                    href="{{ route('portfolio.index') }}#about"
                    @click="mobileMenuOpen = false"
                    class="rounded-lg px-3 py-2 hover:bg-slate-800 hover:text-emerald-400 transition"
                >
                    Tentang
                </a>
                <a
                    href="{{ route('portfolio.index') }}#skills"
                    @click="mobileMenuOpen = false"
                    class="rounded-lg px-3 py-2 hover:bg-slate-800 hover:text-emerald-400 transition"
                >
                    Skills
                </a>
                <a
                    href="{{ route('portfolio.index') }}#projects"
                    @click="mobileMenuOpen = false"
                    class="rounded-lg px-3 py-2 hover:bg-slate-800 hover:text-emerald-400 transition"
                >
                    Projects
                </a>
                <a
                    href="{{ route('portfolio.index') }}#experience"
                    @click="mobileMenuOpen = false"
                    class="rounded-lg px-3 py-2 hover:bg-slate-800 hover:text-emerald-400 transition"
                >
                    Pengalaman
                </a>

                <div class="pt-2 flex flex-col gap-2 border-t border-slate-800">
                    <a
                        href="{{ route('portfolio.index') }}#contact"
                        @click="mobileMenuOpen = false"
                        class="rounded-lg bg-emerald-500 px-3 py-2 text-center text-xs font-semibold text-slate-950 hover:bg-emerald-400 transition"
                    >
                        Kontak
                    </a>
                    @auth
                        <a
                            href="{{ route('admin.dashboard') }}"
                            @click="mobileMenuOpen = false"
                            class="rounded-lg border border-cyan-500/40 bg-cyan-500/10 px-3 py-2 text-center text-xs font-semibold text-cyan-300 hover:bg-cyan-500/20 transition"
                        >
                            Admin Panel
                        </a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="mt-20 border-t border-slate-800/80 bg-slate-950 py-8 text-xs text-slate-400">
        <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 px-4 sm:flex-row sm:px-6">
            <p>© {{ date('Y') }} Ahmad Hanif. Dibangun dengan Laravel, Tailwind CSS & Alpine.js.</p>
            <div class="flex items-center gap-4">
                <a href="https://github.com/MakotoAi" target="_blank" rel="noopener noreferrer" class="hover:text-white transition">
                    GitHub
                </a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-400 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-emerald-400 transition">
                        Login Admin
                    </a>
                @endauth
            </div>
        </div>
    </footer>
</body>
</html>
