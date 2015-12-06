<?php

namespace GifSlideshow;

use AppBundle\Entity\Gif;
use AppBundle\Entity\Providers\Provider;
use AppBundle\Entity\Providers\Query;

class GiphyGrabber extends Grabber
{

    public function getFromQuery(Provider $provider, Query $query)
    {
        $queryString = $query->getQuery();
        $url = $this->buildUrl($queryString);
        $data = json_decode($this->getUrl($url));

        $gifData = $data->data;

        $gif = new Gif();
        $gif->setUrl($gifData->image_original_url);
        return $gif;
    }

    private function buildUrl($query)
    {
        $base_url = "http://api.giphy.com/v1/gifs/random?api_key=dc6zaTOxFJmzC&tag=%s";
        return sprintf($base_url, urlencode($query));
    }




}