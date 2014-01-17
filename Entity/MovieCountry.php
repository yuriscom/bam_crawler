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
     * @ORM\ManyToOne(targetEntity="Movie", inversedBy="movie_country", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    public $movie;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="movie_country", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    public $country;

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
     * Set movie
     *
     * @param \Entity\Movie $movie
     * @return MovieCountry
     */
    public function setMovie(\Entity\Movie $movie = null)
    {
        $this->movie = $movie;

        return $this;
    }

    /**
     * Get movie
     *
     * @return \Entity\Movie 
     */
    public function getMovie()
    {
        return $this->movie;
    }

    /**
     * Set country
     *
     * @param \Entity\Country $country
     * @return MovieCountry
     */
    public function setCountry(\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }
}
