<?php

namespace GifSlideshow;

use AppBundle\Entity\Gif;
use AppBundle\Entity\Providers\Provider;
use AppBundle\Entity\Providers\Query;
use AppBundle\Entity\Providers\RedditProvider;

class RedditGrabber extends Grabber
{

    public function getFromQuery(Provider $provider, Query $query)
    {
        if(! $provider instanceof RedditProvider){
            throw new \InvalidArgumentException("The RedditGrabber requires a RedditProvider to be passed");
        }
        $url = $this->buildUrl($provider);
        $data = json_decode($this->getUrl($url));


        $gif = new Gif();
        $gif->setUrl(null);
        return $gif;
    }

    private function buildUrl(RedditProvider $provider)
    {
        $base_url = "http://reddit.com/r/%s/random.json";
        return sprintf($base_url, $provider->getSubreddit());
    }

}