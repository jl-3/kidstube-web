<?php

namespace App\Jobs;

use App\Helpers\YouTubeLinkParser;
use App\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DownloadYoutubeVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * URL of the video on YouTube
     * @var string
     */
    public $videoURL;

    /**
     * Indicates the success of the downloading/storing process.
     * @var bool
     */
    public $success;

    /**
     * Create a new job instance.
     *
     * @param string $videoURL
     */
    public function __construct($videoURL)
    {
        $this->videoURL = $videoURL;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->success = false;
        $parser = new YouTubeLinkParser($this->videoURL);
        if (!$parser->url) {
            Log::info('Unable to download video from '.$this->videoURL);
            Log::info('YouTube returned following data:', ['data' => $parser->data, 'error' => $parser->error]);
        } else {
            $localPath = $parser->id.'.mp4';
            Storage::disk('public')->put($localPath, fopen($parser->url, 'r'));
            Log::info('Video from '.$this->videoURL.' has been stored to '.$localPath);

            $video = Video::where('url', $this->videoURL)->first();
            if ($video) {
                $video->type = 1;
                $video->size = Storage::disk('public')->size($localPath);
                $video->url = Storage::disk('public')->url($localPath);
                $video->save();
                Log::info('Replaced video URL in the database from '.$this->videoURL.' to '.$video->url);
                $this->success = true;
            }
        }
    }
}
