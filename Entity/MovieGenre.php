<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="movie_genre")
 */
class MovieGenre
{    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity="Movie", inversedBy="movie_genre")
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    public $movies;

    /**
     * @ORM\ManyToOne(targetEntity="Genre", inversedBy="movie_genre")
     * @ORM\JoinColumn(name="genre_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    public $genres;
    

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
     * @return MovieGenre
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
     * Set genres
     *
     * @param \Entity\Genre $genres
     * @return MovieGenre
     */
    public function setGenres(\Entity\Genre $genres = null)
    {
        $this->genres = $genres;

        return $this;
    }

    /**
     * Get genres
     *
     * @return \Entity\Genre 
     */
    public function getGenres()
    {
        return $this->genres;
    }
}
