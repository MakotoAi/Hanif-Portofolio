@extends('layouts.admin')

@section('title', 'Kelola Skills')

@section('content')
<h1 class="text-2xl font-bold text-white mb-6">Skills</h1>

<form action="{{ route('admin.skills.store') }}" method="POST" class="mb-8 flex flex-wrap gap-3 rounded-xl border border-slate-800 bg-slate-900/70 p-4">
    @csrf
    <input type="text" name="name" placeholder="Nama Skill (mis. Docker)" required class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-white">
    <input type="text" name="category" placeholder="Kategori (backend/mobile/tools)" required class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-white">
    <input type="number" name="sort_order" value="0" min="0" class="w-24 rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-white">
    <button type="submit" class="rounded-lg bg-emerald-500 px-4 py-2 text-xs font-semibold text-slate-950 hover:bg-emerald-400">
        + Tambah Skill
    </button>
</form>

<div class="overflow-x-auto rounded-xl border border-slate-800 bg-slate-900/70">
    <table class="w-full text-left text-sm">
        <thead class="border-b border-slate-800 text-xs uppercase text-slate-400">
            <tr>
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Kategori</th>
                <th class="px-4 py-3">Urutan</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800">
            @foreach($skills as $skill)
                <tr>
                    <td class="px-4 py-3 font-medium text-white">{{ $skill->name }}</td>
                    <td class="px-4 py-3 text-cyan-400 uppercase text-xs">{{ $skill->category }}</td>
                    <td class="px-4 py-3 text-xs text-slate-300">{{ $skill->sort_order }}</td>
                    <td class="px-4 py-3 text-right text-xs">
                        <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" class="inline" onsubmit="return confirm('Hapus skill ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-400 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
