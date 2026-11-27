<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GitHubService
{
    protected string $username;
    protected ?string $token;
    protected string $baseUrl = 'https://api.github.com';

    public function __construct()
    {
        $this->username = config('services.github.username', 'MakotoAi');
        $this->token = config('services.github.token');
    }

    /**
     * Ambil daftar repositori publik terbaru (di-cache selama 6 jam).
     */
    public function getRepositories(int $limit = 30): array
    {
        return Cache::remember("github_repos_{$this->username}_{$limit}", now()->addHours(6), function () use ($limit) {
            try {
                $request = Http::withHeaders([
                    'Accept' => 'application/vnd.github+json',
                    'User-Agent' => 'Laravel-Portfolio-App',
                ])->timeout(8);

                if (! empty($this->token)) {
                    $request->withToken($this->token);
                }

                $response = $request->get("{$this->baseUrl}/users/{$this->username}/repos", [
                    'sort' => 'updated',
                    'direction' => 'desc',
                    'per_page' => $limit,
                    'type' => 'owner',
                ]);

                if ($response->failed()) {
                    return [];
                }

                return collect($response->json())
                    ->reject(fn (array $repo) => $repo['fork'] ?? false)
                    ->map(fn (array $repo) => [
                        'name' => $repo['name'] ?? '',
                        'html_url' => $repo['html_url'] ?? '',
                        'language' => $repo['language'] ?? null,
                        'stars' => (int) ($repo['stargazers_count'] ?? 0),
                        'forks' => (int) ($repo['forks_count'] ?? 0),
                    ])
                    ->values()
                    ->all();
            } catch (\Throwable $e) {
                Log::warning('Gagal mengambil data repositori GitHub: ' . $e->getMessage());

                return [];
            }
        });
    }

    /**
     * Petakan statistik repo berdasarkan URL GitHub (dinormalisasi huruf kecil & tanpa trailing slash).
     */
    public function getStatsMapByUrl(): array
    {
        return collect($this->getRepositories(30))
            ->filter(fn (array $repo) => ! empty($repo['html_url']))
            ->keyBy(fn (array $repo) => $this->normalizeUrl($repo['html_url']))
            ->all();
    }

    public function clearCache(): void
    {
        Cache::forget("github_repos_{$this->username}_30");
    }

    public function normalizeUrl(string $url): string
    {
        return rtrim(strtolower(trim($url)), '/');
    }
}
