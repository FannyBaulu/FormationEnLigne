<?php

namespace App\Youtube;

use DateInterval;
use Illuminate\Support\Facades\Http;

class YoutubeServices {

    private $key = null;

    public function __construct(string $key){
        $this->key = $key;
    }

    /**
     * Using the video url parameter, it identify the id. Then it calls the Youtube Video API to get
     * the duration of the video using the id and the API Key. Once the duration has been fetched, it
     * is converted into seconds.
     *
     * @param string $video_url
     */
    public function handleYoutubeVideoDuration(string $video_url){

        preg_match('/embed\/(.+)/',$video_url,$matches);
        $id = $matches[1];
        $response = Http::get("https://www.googleapis.com/youtube/v3/videos?key={$this->key}&id={$id}&part=contentDetails");
        $duration = (json_decode($response))->items[0]->contentDetails->duration;
        $interval = new DateInterval($duration);
        return $interval->s + $interval->i * 60 + $interval->h *3600;    

    }
}