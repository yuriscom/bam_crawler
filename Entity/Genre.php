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
     * @ORM\OneToMany(targetEntity="MovieGenre", mappedBy="genres")
     **/
    public $movies_genres;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->movies_genres = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add movies_genres
     *
     * @param \Entity\MovieGenre $moviesGenres
     * @return Genre
     */
    public function addMoviesGenre(\Entity\MovieGenre $moviesGenres)
    {
        $this->movies_genres[] = $moviesGenres;

        return $this;
    }

    /**
     * Remove movies_genres
     *
     * @param \Entity\MovieGenre $moviesGenres
     */
    public function removeMoviesGenre(\Entity\MovieGenre $moviesGenres)
    {
        $this->movies_genres->removeElement($moviesGenres);
    }

    /**
     * Get movies_genres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMoviesGenres()
    {
        return $this->movies_genres;
    }
}
