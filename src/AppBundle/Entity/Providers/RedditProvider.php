<?php

namespace AppBundle\Entity\Providers;

use AppBundle\Entity\Slideshow;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class RedditProvider
 * @package AppBundle\Entity\Providers
 * @ORM\Entity()
 */
class RedditProvider extends Provider
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Slideshow", inversedBy="redditProviders")
     * @ORM\JoinColumn(name="slideshow_id", referencedColumnName="id")
     */
    private $slideshow;

    /**
     * @ORM\Column(type="string")
     */
    private $subreddit;

    /**
     * Set slideshow
     *
     * @param Slideshow $slideshow
     *
     * @return RedditProvider
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

    /**
     * Set subreddit
     *
     * @param string $subreddit
     *
     * @return RedditProvider
     */
    public function setSubreddit($subreddit)
    {
        $this->subreddit = $subreddit;

        return $this;
    }

    /**
     * Get subreddit
     *
     * @return string
     */
    public function getSubreddit()
    {
        return $this->subreddit;
    }

    function getServiceName()
    {
        return "app_grabber_reddit";
    }
}
