<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="movie_jenre")
 */
class MovieJenre
{    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity="Movie", inversedBy="movie_jenre")
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    public $movies;

    /**
     * @ORM\ManyToOne(targetEntity="Jenre", inversedBy="movie_jenre")
     * @ORM\JoinColumn(name="jenre_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    public $jenres;
    

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
     * @return MovieJenre
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
     * Set jenres
     *
     * @param \Entity\Jenre $jenres
     * @return MovieJenre
     */
    public function setJenres(\Entity\Jenre $jenres = null)
    {
        $this->jenres = $jenres;

        return $this;
    }

    /**
     * Get jenres
     *
     * @return \Entity\Jenre 
     */
    public function getJenres()
    {
        return $this->jenres;
    }
}
