<?php

namespace App\Console\Commands;

use App\Helpers\YouTubeLinkParser;
use App\Jobs\DownloadYoutubeVideo;
use App\Video;
use Illuminate\Console\Command;

class VideosDownload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloads the first non-downloaded video from YouTube and switches its type in the database to local mp4 video.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $success = false;
        while (!$success) {
            $video = Video::where('type', 0)->first();
            if ($video) {
                $this->info('Trying to download and convert video #'.$video->id.' ('.$video->url.')...');
                try {
                    $job = new DownloadYoutubeVideo($video->url);
                    $job->handle();
                    $success = $job->success;
                } catch (\Error $exception) {
                    $success = false;
                }
                if ($success) {
                    $this->info('Done!');
                } else {
                    $this->info('Failed, will try the next video...');
                }
            } else {
                $this->info('There are no more videos to download in the database. Congratulations!');
                break;
            }
        }
    }
}
