<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * Class Gif
 * @ORM\Entity()
 * @ORM\Table(name="Gif")
 * @package AppBundle\Entity
 */
class Gif
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="caption", nullable=false)
     * @var string
     */
    private $caption = "";

    /**
     * @ORM\Column(type="string", name="url", nullable=false)
     * @var string
     */
    private $url;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Slideshow",
     *     inversedBy="gifs"
     * )
     * @ORM\JoinColumn(
     *     name="slideshowId",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $slideshow;

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
     * Set caption
     *
     * @param string $caption
     *
     * @return Gif
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Gif
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set slideshow
     *
     * @param \AppBundle\Entity\Slideshow $slideshow
     *
     * @return Gif
     */
    public function setSlideshow(\AppBundle\Entity\Slideshow $slideshow)
    {
        $this->slideshow = $slideshow;

        return $this;
    }

    /**
     * Get slideshow
     *
     * @return \AppBundle\Entity\Slideshow
     */
    public function getSlideshow()
    {
        return $this->slideshow;
    }
}
