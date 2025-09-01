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

        $author = Author::firstOrCreate(['name' => $authorName], ['is_published' => true]);
        $category = Category::firstOrCreate(['name' => $categoryName], ['is_published' => true]);

        $process = new Process(['yt-dlp', '--dump-single-json', '--flat-playlist', $playlistUrl]);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error('Failed to fetch playlist data. Make sure yt-dlp is installed and the playlist URL is correct.');
            return 1;
        }

        $playlistData = json_decode($process->getOutput(), true);
        $videos = $playlistData['entries'];

        $bar = $this->output->createProgressBar(count($videos));
        $bar->start();

        foreach ($videos as $video) {
            $videoUrl = 'https://www.youtube.com/watch?v=' . $video['id'];
            $this->info("Fetching video data for {$videoUrl}");
            $process = new Process(['yt-dlp', '--dump-single-json', $videoUrl]);
            $process->run();

            if (!$process->isSuccessful()) {
                $this->error("Failed to fetch video data for {$videoUrl}");
                continue;
            }

            $videoData = json_decode($process->getOutput(), true);

            Post::create([
                'title' => $videoData['title'],
                'description' => $videoData['description'],
                'video' => $videoUrl,
                'author_id' => $author->id,
                'category_id' => $category->id,
                'is_published' => true,
                'type' => 'video',
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->info('\nPlaylist imported successfully.');

        return 0;
    }
}
