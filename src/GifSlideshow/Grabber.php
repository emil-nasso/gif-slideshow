<?php

namespace GifSlideshow;


use AppBundle\Entity\Gif;
use AppBundle\Entity\Providers\Provider;
use AppBundle\Entity\Providers\Query;

abstract class Grabber
{
    /**
     * @var WeightableRandomizer
     */
    private $randomizer;

    public function __construct(WeightableRandomizer $randomizer)
    {
        $this->randomizer = $randomizer;
    }

    /**
     * @param Provider $provider
     * @return Gif
     * @throws \Exception
     */
    public function getFromProvider(Provider $provider)
    {
        $queries = $provider->getQueries();
        $query = null;
        if($queries->count() !== 0){
            $query = $this->randomizer->getRandom($queries);
        }
        return $this->getFromQuery($provider, $query);

    }

    protected function getUrl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    abstract protected function getFromQuery(Provider $provider, Query $query);

}