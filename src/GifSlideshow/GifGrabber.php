<?php

namespace GifSlideshow;

use AppBundle\Entity\Gif;
use AppBundle\Entity\Slideshow;

class GifGrabber
{
    private function buildUrl($query)
    {
        $base_url = "http://api.giphy.com/v1/gifs/random?api_key=dc6zaTOxFJmzC&tag=%s";
        return sprintf($base_url, urlencode($query));
    }

    public function run(Slideshow $slidehow)
    {
        $query = array_rand(array_flip($slidehow->getQueries()));
        $url = $this->buildUrl($query);
        $data = json_decode($this->grabUrl($url));

        $gifData = $data->data;

        $gif = new Gif();
        $gif->setUrl($gifData->image_original_url);
        return $gif;
    }

    private function grabUrl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}