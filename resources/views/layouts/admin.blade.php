<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') — hanif.dev</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 antialiased">
    @php
        $unreadCount = \App\Models\Message::unread()->count();
    @endphp

    <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-3.5 sm:px-6">
            <div class="flex items-center gap-6">
                <a href="{{ route('admin.dashboard') }}" class="text-base font-bold text-white">
                    admin<span class="text-emerald-400">.hanif.dev</span>
                </a>

                <nav class="flex flex-wrap items-center gap-4 text-xs font-medium text-slate-300">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-400 transition">Dashboard</a>
                    <a href="{{ route('admin.projects.index') }}" class="hover:text-emerald-400 transition">Projects</a>
                    <a href="{{ route('admin.skills.index') }}" class="hover:text-emerald-400 transition">Skills</a>
                    <a href="{{ route('admin.experiences.index') }}" class="hover:text-emerald-400 transition">Experiences</a>
                    <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center gap-1.5 hover:text-emerald-400 transition">
                        <span>Messages</span>
                        @if($unreadCount > 0)
                            <span class="rounded-full bg-emerald-500 px-2 py-0.5 text-[10px] font-bold text-slate-950">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>
                </nav>
            </div>

            <div class="flex items-center gap-4 text-xs">
                <a href="{{ route('portfolio.index') }}" target="_blank" class="text-cyan-400 hover:underline">
                    Lihat Web &nearr;
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-md border border-slate-700 bg-slate-800 px-3 py-1.5 text-slate-200 hover:bg-slate-700 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6">
        @if(session('status'))
            <div class="mb-6 rounded-lg border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-lg border border-rose-500/40 bg-rose-500/10 px-4 py-3 text-sm text-rose-300">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
