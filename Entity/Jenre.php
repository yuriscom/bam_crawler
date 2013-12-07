<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="jenre", indexes={@ORM\Index(name="name_idx", columns={"name"})})
 */
class Jenre
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
     * @ORM\OneToMany(targetEntity="MovieJenre", mappedBy="jenres")
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
     * Set name
     *
     * @param string $name
     * @return Jenre
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
     * Add movies_jenres
     *
     * @param \Entity\MovieJenre $moviesJenres
     * @return Jenre
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
