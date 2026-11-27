<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Honeypot sederhana untuk menangkal bot spam
        if ($request->filled('website')) {
            return redirect()->to(route('portfolio.index') . '#contact');
        }

        $validated = $request->validate([
            'sender_name' => ['required', 'string', 'max:120'],
            'sender_email' => ['required', 'email:rfc', 'max:150'],
            'subject' => ['nullable', 'string', 'max:180'],
            'body' => ['required', 'string', 'min:10', 'max:3000'],
        ], [
            'sender_name.required' => 'Nama wajib diisi.',
            'sender_email.required' => 'Alamat email wajib diisi.',
            'sender_email.email' => 'Format alamat email tidak valid.',
            'body.required' => 'Isi pesan tidak boleh kosong.',
            'body.min' => 'Pesan minimal berisi 10 karakter.',
        ]);

        Message::create([
            'sender_name' => $validated['sender_name'],
            'sender_email' => $validated['sender_email'],
            'subject' => $validated['subject'] ?? null,
            'body' => $validated['body'],
            'is_read' => false,
            'ip_address' => $request->ip(),
        ]);

        return redirect()
            ->to(route('portfolio.index') . '#contact')
            ->with('contact_status', 'Terima kasih! Pesan kamu sudah terkirim dan akan segera dibalas.');
    }
}
