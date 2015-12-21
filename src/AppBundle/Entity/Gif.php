<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Slideshow;
use Doctrine\ORM\Mapping AS ORM;

/**
 * Class Gif
 * @ORM\Entity()
 * @ORM\Table(name="Gif")
 * @package AppBundle\Entity
 */
class Gif implements \JsonSerializable
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
     * @param Slideshow $slideshow
     *
     * @return Gif
     */
    public function setSlideshow(Slideshow $slideshow)
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
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'slideshowId' => $this->getSlideshow() ? $this->getSlideshow()->getId() : null,
            'url' => $this->getUrl(),
            'caption' => $this->getCaption()
        ];
    }
}
