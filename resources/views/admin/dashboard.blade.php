@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Dashboard Admin</h1>
            <p class="text-sm text-slate-400">Ringkasan konten portofolio dan pesan masuk.</p>
        </div>

        <form action="{{ route('admin.sync-github') }}" method="POST">
            @csrf
            <button type="submit" class="rounded-lg border border-cyan-500/40 bg-cyan-500/10 px-4 py-2 text-xs font-semibold text-cyan-300 hover:bg-cyan-500/20 transition">
                Sync Data GitHub
            </button>
        </form>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-slate-800 bg-slate-900/70 p-5">
            <p class="text-xs text-slate-400">Total Projects</p>
            <p class="mt-2 text-3xl font-bold text-white">{{ $projectsCount }}</p>
        </div>
        <div class="rounded-xl border border-slate-800 bg-slate-900/70 p-5">
            <p class="text-xs text-slate-400">Total Skills</p>
            <p class="mt-2 text-3xl font-bold text-cyan-400">{{ $skillsCount }}</p>
        </div>
        <div class="rounded-xl border border-slate-800 bg-slate-900/70 p-5">
            <p class="text-xs text-slate-400">Experiences</p>
            <p class="mt-2 text-3xl font-bold text-white">{{ $experiencesCount }}</p>
        </div>
        <div class="rounded-xl border border-slate-800 bg-slate-900/70 p-5">
            <p class="text-xs text-slate-400">Pesan Belum Dibaca</p>
            <p class="mt-2 text-3xl font-bold text-emerald-400">{{ $unreadMessagesCount }}</p>
        </div>
    </div>

    <div class="rounded-xl border border-slate-800 bg-slate-900/70 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-bold text-white">Pesan Terbaru</h2>
            <a href="{{ route('admin.messages.index') }}" class="text-xs text-emerald-400 hover:underline">Lihat semua &rarr;</a>
        </div>

        @if($recentMessages->isEmpty())
            <p class="text-sm text-slate-400">Belum ada pesan masuk.</p>
        @else
            <div class="divide-y divide-slate-800">
                @foreach($recentMessages as $msg)
                    <div class="flex flex-wrap items-center justify-between gap-2 py-3 text-sm">
                        <div>
                            <a href="{{ route('admin.messages.show', $msg) }}" class="font-semibold text-white hover:text-emerald-400">
                                {{ $msg->subject ?: '(Tanpa Subjek)' }}
                            </a>
                            <span class="text-xs text-slate-400"> — {{ $msg->sender_name }} ({{ $msg->sender_email }})</span>
                        </div>
                        <span class="text-xs {{ $msg->is_read ? 'text-slate-500' : 'text-emerald-400 font-semibold' }}">
                            {{ $msg->is_read ? 'Dibaca' : 'Baru' }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
