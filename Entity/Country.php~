<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="country", indexes={@ORM\Index(name="country__name__idx", columns={"name"})})
 */
class Country
{    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    public $name;
    
    /**
     * @ORM\OneToMany(targetEntity="MovieCountry", mappedBy="countries")
     **/
    public $movies_countries;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->movies_countries = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Country
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
     * Add movies_countries
     *
     * @param \Entity\MovieCountry $moviesCountries
     * @return Country
     */
    public function addMoviesCountry(\Entity\MovieCountry $moviesCountries)
    {
        $this->movies_countries[] = $moviesCountries;

        return $this;
    }

    /**
     * Remove movies_countries
     *
     * @param \Entity\MovieCountry $moviesCountries
     */
    public function removeMoviesCountry(\Entity\MovieCountry $moviesCountries)
    {
        $this->movies_countries->removeElement($moviesCountries);
    }

    /**
     * Get movies_countries
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMoviesCountries()
    {
        return $this->movies_countries;
    }
}
