<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="genre", indexes={@ORM\Index(name="genre__name__idx", columns={"name"})})
 */
class Genre
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
     * @ORM\OneToMany(targetEntity="MovieGenre", mappedBy="genre")
     **/
    public $genre_movies;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->genre_movies = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Genre
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
     * Add genre_movies
     *
     * @param \Entity\MovieGenre $genreMovies
     * @return Genre
     */
    public function addGenreMovie(\Entity\MovieGenre $genreMovies)
    {
        $this->genre_movies[] = $genreMovies;

        return $this;
    }

    /**
     * Remove genre_movies
     *
     * @param \Entity\MovieGenre $genreMovies
     */
    public function removeGenreMovie(\Entity\MovieGenre $genreMovies)
    {
        $this->genre_movies->removeElement($genreMovies);
    }

    /**
     * Get genre_movies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGenreMovies()
    {
        return $this->genre_movies;
    }
}
