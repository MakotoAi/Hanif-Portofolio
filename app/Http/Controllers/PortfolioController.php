<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use App\Services\GitHubService;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(GitHubService $github): View
    {
        $githubMap = $github->getStatsMapByUrl();

        $projects = Project::ordered()->get()->map(function (Project $project) use ($github, $githubMap) {
            $normalizedUrl = $project->github_url
                ? $github->normalizeUrl($project->github_url)
                : null;

            $project->setAttribute('github_stats', $normalizedUrl ? ($githubMap[$normalizedUrl] ?? null) : null);

            return $project;
        });

        $skillsByCategory = Skill::ordered()->get()->groupBy('category');
        $experiences = Experience::ordered()->get();

        $categories = $projects
            ->pluck('category')
            ->filter()
            ->unique()
            ->values();

        return view('portfolio.index', compact(
            'projects',
            'skillsByCategory',
            'experiences',
            'categories'
        ));
    }

    public function show(Project $project, GitHubService $github): View
    {
        $githubMap = $github->getStatsMapByUrl();
        $normalizedUrl = $project->github_url
            ? $github->normalizeUrl($project->github_url)
            : null;

        $project->setAttribute('github_stats', $normalizedUrl ? ($githubMap[$normalizedUrl] ?? null) : null);

        return view('portfolio.show', compact('project'));
    }
}
