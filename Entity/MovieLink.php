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
     * @ORM\ManyToOne(targetEntity="Movie", inversedBy="movie_link", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    public $movie;
    

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
     * Set movie
     *
     * @param \Entity\Movie $movie
     * @return MovieLink
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
}
