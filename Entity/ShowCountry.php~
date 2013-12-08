<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tvshow_country")
 */
class ShowCountry
{    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity="Show", inversedBy="show_country")
     * @ORM\JoinColumn(name="show_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    public $show;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="movie_country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    public $country;

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
     * @return ShowCountry
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
     * Set country
     *
     * @param \Entity\Country $country
     * @return ShowCountry
     */
    public function setCountry(\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }
}
