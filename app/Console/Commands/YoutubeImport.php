<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Category;
use App\Models\Post;
use Google\Client;
use Google\Service\YouTube;
use Illuminate\Console\Command;
use GuzzleHttp\Client as GuzzleClient;

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

        $apiKey = config('services.youtube.api_key');
        if (empty($apiKey)) {
            $this->error('YouTube API key is not configured. Please add YOUTUBE_API_KEY to your .env file.');
            return 1;
        }

        $client = new Client();
        $client->setApplicationName('YoutubeImportCommand');
        $client->setDeveloperKey($apiKey);
        $youtube = new YouTube($client);

        $playlistId = $this->getPlaylistIdFromUrl($playlistUrl);

        if (!$playlistId) {
            $this->error('Could not extract playlist ID from the URL.');
            return 1;
        }
        
        $this->info('Fetching playlist data...');
        
        $videos = $this->fetchPlaylistItems($youtube, $playlistId);

        if (empty($videos)) {
            $this->warn('No videos found in the playlist or an error occurred.');
            return 0;
        }

        $this->info("Found " . count($videos) . " videos in playlist.");

        $bar = $this->output->createProgressBar(count($videos));
        $bar->start();

        $importedCount = 0;
        $failedCount = 0;

        foreach ($videos as $videoItem) {
            $videoId = $videoItem->getSnippet()->getResourceId()->getVideoId();
            $videoUrl = 'https://www.youtube.com/watch?v=' . $videoId;

            try {
                $videoData = $this->fetchVideoData($youtube, $videoId);

                if (!$videoData) {
                    $this->warn("Failed to fetch video data for {$videoUrl}");
                    $failedCount++;
                    continue;
                }

                // Check if post already exists
                $existingPost = Post::where('video', $videoUrl)->first();
                if ($existingPost) {
                    $this->warn("Video already exists: {$videoData->getSnippet()->getTitle()}");
                    continue;
                }

                Post::create([
                    'title' => $videoData->getSnippet()->getTitle(),
                    'description' => $videoData->getSnippet()->getDescription() ?? '',
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
        
        // No longer need to ensure proper YouTube playlist format here, as getPlaylistIdFromUrl handles extraction.
        // If it's a shortened URL, try to expand it - not strictly necessary for API but good practice.
        // This method can be simplified to just clean the URL without complex validation.
        return $url;
    }

    /**
     * Validate if the URL is a proper YouTube playlist URL
     */
    private function isValidPlaylistUrl(string $url): bool
    {
        // The validation now relies on successful extraction of the playlist ID.
        return (bool) $this->getPlaylistIdFromUrl($url);
    }

    private function getPlaylistIdFromUrl(string $url): ?string
    {
        $query = parse_url($url, PHP_URL_QUERY);
        if ($query) {
            parse_str($query, $params);
            if (isset($params['list'])) {
                return $params['list'];
            }
        }
        return null;
    }

    private function fetchPlaylistItems(YouTube $youtube, string $playlistId): array
    {
        $videos = [];
        $pageToken = null;

        do {
            try {
                $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet,contentDetails', [
                    'playlistId' => $playlistId,
                    'maxResults' => 50,
                    'pageToken' => $pageToken,
                ]);

                foreach ($playlistItemsResponse['items'] as $playlistItem) {
                    $videos[] = $playlistItem;
                }

                $pageToken = $playlistItemsResponse->nextPageToken;
            } catch (\Google\Service\Exception $e) {
                $this->error('Error fetching playlist items: ' . $e->getMessage());
                return [];
            }
        } while ($pageToken);

        return $videos;
    }

    private function fetchVideoData(YouTube $youtube, string $videoId)
    {
        try {
            $videoResponse = $youtube->videos->listVideos('snippet,contentDetails', [
                'id' => $videoId,
            ]);

            if (!empty($videoResponse['items'])) {
                return $videoResponse['items'][0];
            }
        } catch (\Google\Service\Exception $e) {
            $this->error('Error fetching video data: ' . $e->getMessage());
        }
        return null;
    }
}
