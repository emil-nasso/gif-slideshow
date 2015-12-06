<?php

namespace AppBundle\Entity\Providers;


use AppBundle\Entity\Slideshow;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * Class Provider
 * @package AppBundle\Entity\Providers
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class Provider implements ServiceConfiguration, Weightable
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $weight = 10;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Providers\Query", mappedBy="provider", cascade={"persist"})
     */
    private $queries;

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
     * Set weight
     *
     * @param integer $weight
     *
     * @return Provider
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Return the name of the service that this object is the configuration for
     * @return mixed
     * @throws Exception
     */
    function getServiceName()
    {
        throw new Exception("getServiceName is not implemented in subclass");
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->queries = new ArrayCollection();
    }

    /**
     * Add query
     *
     * @param Query $query
     *
     * @return Provider
     */
    public function addQuery(Query $query)
    {
        $this->queries[] = $query;
        $query->setProvider($this);
        return $this;
    }

    /**
     * Remove query
     *
     * @param Query $query
     */
    public function removeQuery(Query $query)
    {
        $query->setProvider(null);
        $this->queries->removeElement($query);
    }

    /**
     * Get queries
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQueries()
    {
        return $this->queries;
    }

    /**
     * @return Slideshow
     */
    function getSlideshow()
    {
        throw new Exception("getSlideshow is not implemented in subclass");
    }
}
