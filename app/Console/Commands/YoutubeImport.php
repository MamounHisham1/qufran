<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class YoutubeImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:import {playlist_url} {--author=} {--category=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import videos from a YouTube playlist into the posts table.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $playlistUrl = $this->argument('playlist_url');
        $authorName = $this->option('author');
        $categoryName = $this->option('category');

        // Clean and validate the URL
        $playlistUrl = $this->cleanPlaylistUrl($playlistUrl);
        
        if (!$this->isValidPlaylistUrl($playlistUrl)) {
            $this->error('Invalid YouTube playlist URL. Please provide a valid URL like: https://www.youtube.com/playlist?list=PLAYLIST_ID');
            return 1;
        }

        $this->info("Processing playlist: {$playlistUrl}");

        $author = Author::firstOrCreate(['name' => $authorName], ['is_published' => true]);
        $category = Category::firstOrCreate(['name' => $categoryName], ['is_published' => true]);

        // Check if yt-dlp is available
        if (!$this->checkYtDlp()) {
            $this->error('yt-dlp is not installed or not accessible. Please install it first.');
            return 1;
        }

        // Use more robust yt-dlp options for server environments
        $ytDlpArgs = [
            'yt-dlp',
            '--dump-single-json',
            '--flat-playlist',
            '--user-agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            '--extractor-args', 'youtube:player_client=web',
            '--no-check-certificates',
            $playlistUrl
        ];
        
        $process = new Process($ytDlpArgs);
        $process->setTimeout(300); // 5 minutes timeout
        
        $this->info('Fetching playlist data...');
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error('Failed to fetch playlist data: ' . $process->getErrorOutput());
            $this->error('Make sure yt-dlp is installed and the playlist URL is correct.');
            return 1;
        }

        $playlistData = json_decode($process->getOutput(), true);
        
        if (!$playlistData || !isset($playlistData['entries'])) {
            $this->error('Invalid playlist data received. The playlist might be private or unavailable.');
            return 1;
        }

        $videos = $playlistData['entries'];
        $this->info("Found " . count($videos) . " videos in playlist.");

        if (empty($videos)) {
            $this->warn('No videos found in the playlist.');
            return 0;
        }

        $bar = $this->output->createProgressBar(count($videos));
        $bar->start();

        $importedCount = 0;
        $failedCount = 0;

        foreach ($videos as $video) {
            if (!isset($video['id'])) {
                $this->warn('Skipping video without ID');
                continue;
            }

            $videoUrl = 'https://www.youtube.com/watch?v=' . $video['id'];
            
            try {
                // Use more robust yt-dlp options for server environments
                $ytDlpArgs = [
                    'yt-dlp',
                    '--dump-single-json',
                    '--user-agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    '--extractor-args', 'youtube:player_client=web',
                    '--no-check-certificates',
                    $videoUrl
                ];
                
                $process = new Process($ytDlpArgs);
                $process->setTimeout(120); // 2 minutes timeout
                $process->run();

                if (!$process->isSuccessful()) {
                    $this->warn("Failed to fetch video data for {$videoUrl}: " . $process->getErrorOutput());
                    $failedCount++;
                    continue;
                }

                $videoData = json_decode($process->getOutput(), true);
                
                if (!$videoData || !isset($videoData['title'])) {
                    $this->warn("Invalid video data for {$videoUrl}");
                    $failedCount++;
                    continue;
                }

                // Check if post already exists
                $existingPost = Post::where('video', $videoUrl)->first();
                if ($existingPost) {
                    $this->warn("Video already exists: {$videoData['title']}");
                    continue;
                }

                Post::create([
                    'title' => $videoData['title'],
                    'description' => $videoData['description'] ?? '',
                    'video' => $videoUrl,
                    'author_id' => $author->id,
                    'category_id' => $category->id,
                    'is_published' => true,
                    'type' => 'video',
                ]);

                $importedCount++;
                $bar->advance();
                
            } catch (\Exception $e) {
                $this->warn("Error processing video {$videoUrl}: " . $e->getMessage());
                $failedCount++;
                continue;
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info("Import completed successfully!");
        $this->info("Imported: {$importedCount} videos");
        if ($failedCount > 0) {
            $this->warn("Failed: {$failedCount} videos");
        }

        return 0;
    }

    /**
     * Clean and normalize the playlist URL
     */
    private function cleanPlaylistUrl(string $url): string
    {
        // Remove any backslashes that might have been added
        $url = str_replace('\\', '', $url);
        
        // Decode URL if it's encoded
        $url = urldecode($url);
        
        // Ensure proper YouTube playlist format
        if (strpos($url, 'youtube.com/playlist') !== false) {
            return $url;
        }
        
        // If it's a shortened URL, try to expand it
        if (strpos($url, 'youtu.be') !== false) {
            return $url;
        }
        
        return $url;
    }

    /**
     * Validate if the URL is a proper YouTube playlist URL
     */
    private function isValidPlaylistUrl(string $url): bool
    {
        $patterns = [
            '/^https?:\/\/(www\.)?youtube\.com\/playlist\?list=[a-zA-Z0-9_-]+/',
            '/^https?:\/\/(www\.)?youtu\.be\/[a-zA-Z0-9_-]+/',
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if yt-dlp is available and working
     */
    private function checkYtDlp(): bool
    {
        try {
            $process = new Process(['yt-dlp', '--version']);
            $process->run();
            return $process->isSuccessful();
        } catch (\Exception $e) {
            return false;
        }
    }
}
