<?php

namespace AppBundle\Entity\Providers;

use AppBundle\Entity\Slideshow;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class GiphyProvider
 * @package AppBundle\Entity\Providers
 * @ORM\Entity()
 */
class GiphyProvider extends Provider
{

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Slideshow", inversedBy="giphyProviders")
     * @ORM\JoinColumn(name="slideshow_id", referencedColumnName="id")
     */
    private $slideshow;

    /**
     * Set slideshow
     *
     * @param Slideshow $slideshow
     *
     * @return GiphyProvider
     */
    public function setSlideshow(Slideshow $slideshow = null)
    {
        $this->slideshow = $slideshow;

        return $this;
    }

    /**
     * Get slideshow
     *
     * @return Slideshow
     */
    public function getSlideshow()
    {
        return $this->slideshow;
    }

    function getServiceName()
    {
        return "app_grabber_giphy";
    }
}
