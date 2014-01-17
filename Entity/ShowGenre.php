<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tvshow_genre")
 */
class ShowGenre
{    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity="Show", inversedBy="show_genre")
     * @ORM\JoinColumn(name="show_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    public $show;

    /**
     * @ORM\ManyToOne(targetEntity="Genre", inversedBy="movie_genre")
     * @ORM\JoinColumn(name="genre_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    public $genre;

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
     * Set show
     *
     * @param \Entity\Show $show
     * @return ShowGenre
     */
    public function setShow(\Entity\Show $show = null)
    {
        $this->show = $show;

        return $this;
    }

    /**
     * Get show
     *
     * @return \Entity\Show 
     */
    public function getShow()
    {
        return $this->show;
    }

    /**
     * Set genre
     *
     * @param \Entity\Genre $genre
     * @return ShowGenre
     */
    public function setGenre(\Entity\Genre $genre = null)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return \Entity\Genre 
     */
    public function getGenre()
    {
        return $this->genre;
    }
}
