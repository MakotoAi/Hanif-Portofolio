@extends('layouts.admin')

@section('title', 'Pesan Masuk')

@section('content')
<h1 class="text-2xl font-bold text-white mb-6">Pesan Masuk</h1>

<div class="overflow-x-auto rounded-xl border border-slate-800 bg-slate-900/70">
    <table class="w-full text-left text-sm">
        <thead class="border-b border-slate-800 text-xs uppercase text-slate-400">
            <tr>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Pengirim</th>
                <th class="px-4 py-3">Subjek</th>
                <th class="px-4 py-3">Tanggal</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800">
            @forelse($messages as $msg)
                <tr class="{{ $msg->is_read ? '' : 'bg-emerald-500/5' }}">
                    <td class="px-4 py-3 text-xs font-semibold {{ $msg->is_read ? 'text-slate-500' : 'text-emerald-400' }}">
                        {{ $msg->is_read ? 'Dibaca' : 'Baru' }}
                    </td>
                    <td class="px-4 py-3 text-white">
                        {{ $msg->sender_name }} <span class="block text-xs text-slate-400">{{ $msg->sender_email }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.messages.show', $msg) }}" class="font-medium text-cyan-300 hover:underline">
                            {{ $msg->subject ?: '(Tanpa Subjek)' }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-xs text-slate-400">{{ $msg->created_at?->diffForHumans() }}</td>
                    <td class="px-4 py-3 text-right text-xs">
                        <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pesan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-400 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-slate-400">Belum ada pesan masuk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $messages->links() }}</div>
@endsection
