<?php
namespace common\components;

use yii\base\Component;

class YoutubeChannel extends Component
{
    //const API = 'AIzaSyDivO9HYrtxhIkimi-x0BocOqbnJsmrEb0';
    
    public function youtube($googleAPI,$youtubeChannelID, $maxResult) 
    {
        return $this->getChannel($googleAPI, $youtubeChannelID, $maxResult);
    }
    
    protected function getChannel($googleAPI, $youtubeChannelID, $maxResult) 
    {
        $API = $googleAPI;
        $channelID  = $youtubeChannelID;
        $baseUrl= "https://www.googleapis.com/youtube/v3/";
        $max =  $maxResult;

        $API_URL = $baseUrl . 'search?order=date&part=snippet&channelId='.$channelID.'&maxResult='.$max.'&key='.$API;

        return $API_URL;
    }
}