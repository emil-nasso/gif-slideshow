<?php

namespace GifSlideshow;


use AppBundle\Entity\Providers\Weightable;

class WeightableRandomizer
{
    function getRandom($weightables)
    {
        $totalWeight = 0;
        $objects = [];
        foreach ($weightables as $weightable) {
            /**
             * @var Weightable $weightable
             */
            $totalWeight += $weightable->getWeight();
            $objects[$totalWeight] = $weightable;
        }
        $randomNumber = rand(1, $totalWeight);
        foreach($objects as $roof => $object ){
            if($randomNumber <= $roof){
                return $object;
            }
        }
        throw new \Exception("Unable to pick random object");
    }
}