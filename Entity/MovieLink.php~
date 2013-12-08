<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="movie_link")
 */
class MovieLink
{    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public $link;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    public $version;
    
    /**
     * @ORM\ManyToOne(targetEntity="Movie", inversedBy="movie_link")
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    public $movies;
    
    

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
     * Set link
     *
     * @param string $link
     * @return MovieLink
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set version
     *
     * @param string $version
     * @return MovieLink
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set movies
     *
     * @param \Entity\Movie $movies
     * @return MovieLink
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
}
