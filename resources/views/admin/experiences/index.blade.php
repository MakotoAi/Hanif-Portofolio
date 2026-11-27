@extends('layouts.admin')

@section('title', 'Kelola Experiences')

@section('content')
<h1 class="text-2xl font-bold text-white mb-6">Pendidikan &amp; Pengalaman</h1>

<form action="{{ route('admin.experiences.store') }}" method="POST" class="mb-8 space-y-4 rounded-xl border border-slate-800 bg-slate-900/70 p-5">
    @csrf
    <div class="grid gap-4 sm:grid-cols-3">
        <input type="text" name="role" placeholder="Peran / Gelar / Posisi" required class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-white">
        <input type="text" name="organization" placeholder="Instansi / Kampus / Organisasi" required class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-white">
        <input type="text" name="type" placeholder="Tipe (education/internship/work/organization)" required class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-white">
    </div>
    <div class="grid gap-4 sm:grid-cols-3">
        <div>
            <label class="block text-xs text-slate-400 mb-1">Tanggal Mulai</label>
            <input type="date" name="start_date" required class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-white">
        </div>
        <div>
            <label class="block text-xs text-slate-400 mb-1">Tanggal Selesai</label>
            <input type="date" name="end_date" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-white">
        </div>
        <div class="flex items-end pb-2">
            <label class="inline-flex items-center gap-2 text-xs text-slate-300">
                <input type="checkbox" name="is_current" value="1" class="rounded border-slate-700 bg-slate-950">
                <span>Masih berlangsung (Present)</span>
            </label>
        </div>
    </div>
    <textarea name="description" rows="2" placeholder="Deskripsi singkat..." class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-white"></textarea>
    <button type="submit" class="rounded-lg bg-emerald-500 px-4 py-2 text-xs font-semibold text-slate-950 hover:bg-emerald-400">
        + Tambah Experience
    </button>
</form>

<div class="space-y-3">
    @foreach($experiences as $exp)
        <div class="flex flex-wrap items-center justify-between gap-4 rounded-xl border border-slate-800 bg-slate-900/70 p-4">
            <div>
                <p class="font-bold text-white">{{ $exp->role }} — <span class="text-cyan-400">{{ $exp->organization }}</span></p>
                <p class="text-xs text-slate-400">
                    {{ $exp->type }} &bull; {{ $exp->start_date?->format('M Y') }} &mdash; {{ $exp->is_current ? 'Present' : ($exp->end_date?->format('M Y') ?? '-') }}
                </p>
            </div>
            <form action="{{ route('admin.experiences.destroy', $exp) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs text-rose-400 hover:underline">Hapus</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
