@extends('layouts.admin')

@section('title', 'Kelola Projects')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Projects</h1>
        <p class="text-sm text-slate-400">Kelola daftar proyek dan case study portofolio.</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="rounded-lg bg-emerald-500 px-4 py-2 text-xs font-semibold text-slate-950 hover:bg-emerald-400">
        + Tambah Project
    </a>
</div>

<div class="overflow-x-auto rounded-xl border border-slate-800 bg-slate-900/70">
    <table class="w-full text-left text-sm">
        <thead class="border-b border-slate-800 text-xs uppercase text-slate-400">
            <tr>
                <th class="px-4 py-3">Judul</th>
                <th class="px-4 py-3">Kategori</th>
                <th class="px-4 py-3">Tech Stack</th>
                <th class="px-4 py-3">Featured</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800">
            @forelse($projects as $project)
                <tr>
                    <td class="px-4 py-3 font-medium text-white">{{ $project->title }}</td>
                    <td class="px-4 py-3 text-cyan-400 uppercase text-xs">{{ $project->category }}</td>
                    <td class="px-4 py-3 text-xs text-slate-300">{{ implode(', ', $project->tech_stack ?? []) }}</td>
                    <td class="px-4 py-3 text-xs">{{ $project->is_featured ? 'Ya' : 'Tidak' }}</td>
                    <td class="px-4 py-3 text-right text-xs space-x-2">
                        <a href="{{ route('admin.projects.edit', $project) }}" class="text-emerald-400 hover:underline">Edit</a>
                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Hapus proyek ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-400 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-slate-400">Belum ada proyek.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $projects->links() }}</div>
@endsection
