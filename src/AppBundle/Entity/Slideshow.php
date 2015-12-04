<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Gif;
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
     * @ORM\Column(type="json_array")
     * @var array
     */
    private $queries;

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
     * Constructor
     */
    public function __construct()
    {
        $this->gifs = new ArrayCollection();
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
     * Set queries
     *
     * @param array $queries
     *
     * @return Slideshow
     */
    public function setQueries($queries)
    {
        $this->queries = $queries;

        return $this;
    }

    /**
     * Get queries
     *
     * @return array
     */
    public function getQueries()
    {
        return $this->queries;
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
}
