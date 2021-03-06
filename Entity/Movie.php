<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="movie", indexes={@ORM\Index(name="movie__title__idx", columns={"title"}), @ORM\Index(name="movie__prime_id__idx", columns={"prime_id"})})
 */
class Movie
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
    public $prime_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $title;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public $description;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    public $released;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    public $runtime;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    public $imdb_link;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $updated_on;
    
    /**
     * @ORM\OneToMany(targetEntity="MovieGenre", mappedBy="movie")
     **/
    public $movie_genres;
    
    /**
     * @ORM\OneToMany(targetEntity="MovieCountry", mappedBy="movie")
     **/
    public $movie_countries;
    
    /**
     * @ORM\OneToMany(targetEntity="MovieLink", mappedBy="movie")
     **/
    public $links;
    
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->movie_genres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->movie_countries = new \Doctrine\Common\Collections\ArrayCollection();
        $this->links = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set prime_id
     *
     * @param string $primeId
     * @return Movie
     */
    public function setPrimeId($primeId)
    {
        $this->prime_id = $primeId;

        return $this;
    }

    /**
     * Get prime_id
     *
     * @return string 
     */
    public function getPrimeId()
    {
        return $this->prime_id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Movie
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Movie
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set released
     *
     * @param string $released
     * @return Movie
     */
    public function setReleased($released)
    {
        $this->released = $released;

        return $this;
    }

    /**
     * Get released
     *
     * @return string 
     */
    public function getReleased()
    {
        return $this->released;
    }

    /**
     * Set runtime
     *
     * @param string $runtime
     * @return Movie
     */
    public function setRuntime($runtime)
    {
        $this->runtime = $runtime;

        return $this;
    }

    /**
     * Get runtime
     *
     * @return string 
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * Set imdb_link
     *
     * @param string $imdbLink
     * @return Movie
     */
    public function setImdbLink($imdbLink)
    {
        $this->imdb_link = $imdbLink;

        return $this;
    }

    /**
     * Get imdb_link
     *
     * @return string 
     */
    public function getImdbLink()
    {
        return $this->imdb_link;
    }

    /**
     * Add movie_genres
     *
     * @param \Entity\MovieGenre $movieGenres
     * @return Movie
     */
    public function addMovieGenre(\Entity\MovieGenre $movieGenres)
    {
        $this->movie_genres[] = $movieGenres;

        return $this;
    }

    /**
     * Remove movie_genres
     *
     * @param \Entity\MovieGenre $movieGenres
     */
    public function removeMovieGenre(\Entity\MovieGenre $movieGenres)
    {
        $this->movie_genres->removeElement($movieGenres);
    }

    /**
     * Get movie_genres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovieGenres()
    {
        return $this->movie_genres;
    }

    /**
     * Add movie_countries
     *
     * @param \Entity\MovieCountry $movieCountries
     * @return Movie
     */
    public function addMovieCountry(\Entity\MovieCountry $movieCountries)
    {
        $this->movie_countries[] = $movieCountries;

        return $this;
    }

    /**
     * Remove movie_countries
     *
     * @param \Entity\MovieCountry $movieCountries
     */
    public function removeMovieCountry(\Entity\MovieCountry $movieCountries)
    {
        $this->movie_countries->removeElement($movieCountries);
    }

    /**
     * Get movie_countries
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovieCountries()
    {
        return $this->movie_countries;
    }

    /**
     * Add links
     *
     * @param \Entity\MovieLink $links
     * @return Movie
     */
    public function addLink(\Entity\MovieLink $links)
    {
        $this->links[] = $links;

        return $this;
    }

    /**
     * Remove links
     *
     * @param \Entity\MovieLink $links
     */
    public function removeLink(\Entity\MovieLink $links)
    {
        $this->links->removeElement($links);
    }

    /**
     * Get links
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLinks()
    {
        return $this->links;
    }
}
