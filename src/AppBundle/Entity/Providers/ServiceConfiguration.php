<?php
namespace AppBundle\Entity\Providers;


use AppBundle\Entity\Slideshow;

interface ServiceConfiguration
{
    /**
     * Return the name of the service that this object is the configuration for
     * @return mixed
     */
    function getServiceName();

    /**
     * @return Slideshow
     */
    function getSlideshow();
}