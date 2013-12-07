<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="movie", indexes={@ORM\Index(name="title_idx", columns={"title"}), @ORM\Index(name="prime_id_idx", columns={"prime_id"})})
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
     * @ORM\Column(type="string", nullable=true)
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
     * @ORM\OneToMany(targetEntity="MovieJenre", mappedBy="movies")
     **/
    public $movies_jenres;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->movies_jenres = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add movies_jenres
     *
     * @param \Entity\MovieJenre $moviesJenres
     * @return Movie
     */
    public function addMoviesJenre(\Entity\MovieJenre $moviesJenres)
    {
        $this->movies_jenres[] = $moviesJenres;

        return $this;
    }

    /**
     * Remove movies_jenres
     *
     * @param \Entity\MovieJenre $moviesJenres
     */
    public function removeMoviesJenre(\Entity\MovieJenre $moviesJenres)
    {
        $this->movies_jenres->removeElement($moviesJenres);
    }

    /**
     * Get movies_jenres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMoviesJenres()
    {
        return $this->movies_jenres;
    }
}
