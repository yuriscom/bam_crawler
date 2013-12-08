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
     * @ORM\OneToMany(targetEntity="MovieCountry", mappedBy="country")
     **/
    public $country_movies;
 
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->country_movies = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add country_movies
     *
     * @param \Entity\MovieCountry $countryMovies
     * @return Country
     */
    public function addCountryMovie(\Entity\MovieCountry $countryMovies)
    {
        $this->country_movies[] = $countryMovies;

        return $this;
    }

    /**
     * Remove country_movies
     *
     * @param \Entity\MovieCountry $countryMovies
     */
    public function removeCountryMovie(\Entity\MovieCountry $countryMovies)
    {
        $this->country_movies->removeElement($countryMovies);
    }

    /**
     * Get country_movies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCountryMovies()
    {
        return $this->country_movies;
    }
}
