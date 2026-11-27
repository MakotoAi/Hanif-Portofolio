<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;
use App\Services\GitHubService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'projectsCount' => Project::count(),
            'skillsCount' => Skill::count(),
            'experiencesCount' => Experience::count(),
            'unreadMessagesCount' => Message::unread()->count(),
            'recentMessages' => Message::latest()->take(5)->get(),
        ]);
    }

    public function syncGithub(GitHubService $github): RedirectResponse
    {
        $github->clearCache();
        $repos = $github->getRepositories(30);
        $count = count($repos);

        return redirect()
            ->route('admin.dashboard')
            ->with('status', "Sinkronisasi GitHub selesai ({$count} repositori diperbarui).");
    }
}
