<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Gif;
use AppBundle\Entity\Providers\GiphyProvider;
use AppBundle\Entity\Providers\RedditProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class Slideshow
{

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Gif",
     *     mappedBy="slideshow"
     * )
     */
    private $gifs;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $delay = 5;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Providers\RedditProvider", mappedBy="slideshow", cascade={"persist"})
     */
    private $redditProviders;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Providers\GiphyProvider", mappedBy="slideshow", cascade={"persist"})
     */
    private $giphyProviders;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->gifs = new ArrayCollection();
        $this->redditProviders = new ArrayCollection();
        $this->giphyProviders = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Slideshow
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add gif
     *
     * @param Gif $gif
     *
     * @return Slideshow
     */
    public function addGif(Gif $gif)
    {
        $this->gifs[] = $gif;

        return $this;
    }

    /**
     * Remove gif
     *
     * @param Gif $gif
     */
    public function removeGif(Gif $gif)
    {
        $this->gifs->removeElement($gif);
    }

    /**
     * Get gifs
     *
     * @return Collection
     */
    public function getGifs()
    {
        return $this->gifs;
    }

    /**
     * Set the delay, in seconds
     * @param mixed $delay
     * @return Slideshow
     */
    public function setDelay($delay)
    {
        $this->delay = $delay;
        return $this;
    }

    /**
     * The the delay, in seconds
     * @return mixed
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * Add redditProvider
     *
     * @param RedditProvider $redditProvider
     *
     * @return Slideshow
     */
    public function addRedditProvider(RedditProvider $redditProvider)
    {
        $this->redditProviders[] = $redditProvider;

        $redditProvider->setSlideshow($this);

        return $this;
    }

    /**
     * Remove redditProvider
     *
     * @param RedditProvider $redditProvider
     */
    public function removeRedditProvider(RedditProvider $redditProvider)
    {
        $this->redditProviders->removeElement($redditProvider);
        $redditProvider->setSlideshow(null);
    }

    /**
     * Get redditProviders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRedditProviders()
    {
        return $this->redditProviders;
    }

    /**
     * Add giphyProvider
     *
     * @param GiphyProvider $giphyProvider
     *
     * @return Slideshow
     */
    public function addGiphyProvider(GiphyProvider $giphyProvider)
    {
        $this->giphyProviders[] = $giphyProvider;
        $giphyProvider->setSlideshow($this);

        return $this;
    }

    /**
     * Remove giphyProvider
     *
     * @param GiphyProvider $giphyProvider
     */
    public function removeGiphyProvider(GiphyProvider $giphyProvider)
    {
        $this->giphyProviders->removeElement($giphyProvider);
        $giphyProvider->setSlideshow(null);
    }

    /**
     * Get giphyProviders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGiphyProviders()
    {
        return $this->giphyProviders;
    }

    /**
     * @return ArrayCollection
     */
    public function getAllProviders()
    {
        return new ArrayCollection(
            array_merge(
                $this->getRedditProviders()->toArray(),
                $this->getGiphyProviders()->toArray()
            )
        );
    }
}
