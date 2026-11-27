<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    public function index(): View
    {
        $experiences = Experience::ordered()->get();

        return view('admin.experiences.index', compact('experiences'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'string', 'max:150'],
            'organization' => ['required', 'string', 'max:150'],
            'location' => ['nullable', 'string', 'max:120'],
            'type' => ['required', 'string', 'max:50'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:1500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $isCurrent = $request->boolean('is_current');

        Experience::create([
            ...$validated,
            'is_current' => $isCurrent,
            'end_date' => $isCurrent ? null : ($validated['end_date'] ?? null),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.experiences.index')->with('status', 'Pengalaman berhasil ditambahkan.');
    }

    public function update(Request $request, Experience $experience): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'string', 'max:150'],
            'organization' => ['required', 'string', 'max:150'],
            'location' => ['nullable', 'string', 'max:120'],
            'type' => ['required', 'string', 'max:50'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:1500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $isCurrent = $request->boolean('is_current');

        $experience->update([
            ...$validated,
            'is_current' => $isCurrent,
            'end_date' => $isCurrent ? null : ($validated['end_date'] ?? null),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.experiences.index')->with('status', 'Pengalaman berhasil diperbarui.');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $experience->delete();

        return redirect()->route('admin.experiences.index')->with('status', 'Pengalaman berhasil dihapus.');
    }
}
