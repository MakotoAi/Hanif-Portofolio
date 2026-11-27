@extends('layouts.admin')

@section('title', 'Detail Pesan')

@section('content')
<a href="{{ route('admin.messages.index') }}" class="text-xs text-slate-400 hover:text-emerald-400">&larr; Kembali ke Daftar Pesan</a>

<div class="mt-4 rounded-xl border border-slate-800 bg-slate-900/70 p-6 max-w-2xl space-y-4">
    <div>
        <h1 class="text-xl font-bold text-white">{{ $message->subject ?: '(Tanpa Subjek)' }}</h1>
        <p class="mt-1 text-xs text-slate-400">
            Dari: <span class="text-slate-200">{{ $message->sender_name }}</span> ({{ $message->sender_email }}) &bull; {{ $message->created_at?->format('d M Y H:i') }}
        </p>
    </div>

    <div class="border-t border-slate-800 pt-4 whitespace-pre-line text-sm leading-relaxed text-slate-200">
        {{ $message->body }}
    </div>

    <div class="border-t border-slate-800 pt-4 flex justify-end">
        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-lg bg-rose-500/20 border border-rose-500/40 px-4 py-1.5 text-xs font-semibold text-rose-300 hover:bg-rose-500/30">
                Hapus Pesan
            </button>
        </form>
    </div>
</div>
@endsection
