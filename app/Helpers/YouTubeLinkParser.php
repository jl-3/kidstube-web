<?php

namespace App\Helpers;


class YouTubeLinkParser
{
    /**
     * YouTubeLinkParser constructor.
     * @param string $youtubeUrl
     */
    public function __construct($youtubeUrl)
    {
        $_orginalLink = $youtubeUrl;
        $_videoId = $this->extractYoutubeId($_orginalLink);

        if (!$_videoId) {
            $this->error = 'Invalid link';
            return;
        }

        $vidInfo = 'http://www.youtube.com/get_video_info?&video_id=' . $_videoId . '&asv=3&el=detailpage&hl=en_US';
        $this->data = urldecode(file_get_contents($vidInfo));

        $pattern = '/url=([^&?#]*googlevideo.com[^&?#]*mp4[^&?#]*)/i';
        if (preg_match($pattern, $this->data, $matches)) {
            $this->url = urldecode($matches[1]);
        }
    }

    public $error;

    public $data;

    public $url;

    private function extractYoutubeId($link)
    {
        $pattern = '/v=([a-z0-9_]+)/i';
        if (!preg_match($pattern, $link, $matches)) return null;
        return $matches[1];
    }
}