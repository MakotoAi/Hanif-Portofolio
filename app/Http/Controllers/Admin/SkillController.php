<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function index(): View
    {
        $skills = Skill::ordered()->get();

        return view('admin.skills.index', compact('skills'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        Skill::create([
            'name' => $validated['name'],
            'category' => strtolower(trim($validated['category'])),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.skills.index')->with('status', 'Skill berhasil ditambahkan.');
    }

    public function update(Request $request, Skill $skill): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $skill->update([
            'name' => $validated['name'],
            'category' => strtolower(trim($validated['category'])),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.skills.index')->with('status', 'Skill berhasil diperbarui.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')->with('status', 'Skill berhasil dihapus.');
    }
}
