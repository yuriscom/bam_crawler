<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="movie_country")
 */
class MovieCountry
{    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity="Movie", inversedBy="movie_country")
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    public $movies;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="movie_country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    public $countries;

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
     * Set movies
     *
     * @param \Entity\Movie $movies
     * @return MovieCountry
     */
    public function setMovies(\Entity\Movie $movies = null)
    {
        $this->movies = $movies;

        return $this;
    }

    /**
     * Get movies
     *
     * @return \Entity\Movie 
     */
    public function getMovies()
    {
        return $this->movies;
    }

    /**
     * Set countries
     *
     * @param \Entity\Country $countries
     * @return MovieCountry
     */
    public function setCountries(\Entity\Country $countries = null)
    {
        $this->countries = $countries;

        return $this;
    }

    /**
     * Get countries
     *
     * @return \Entity\Country 
     */
    public function getCountries()
    {
        return $this->countries;
    }
}
