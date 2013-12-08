<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tvshow", indexes={@ORM\Index(name="show__title__idx", columns={"title"}), @ORM\Index(name="show__prime_id__idx", columns={"prime_id"})})
 */
class Show
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
     * @ORM\Column(type="text", nullable=true)
     */
    public $description;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    public $released;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    public $imdb_link;
    
    /**
     * @ORM\OneToMany(targetEntity="ShowGenre", mappedBy="show")
     **/
    public $show_genres;
    
    /**
     * @ORM\OneToMany(targetEntity="ShowCountry", mappedBy="show")
     **/
    public $show_countries;
    
    /**
     * @ORM\OneToMany(targetEntity="ShowEpisode", mappedBy="show")
     **/
    public $show_episodes;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->show_genres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->show_countries = new \Doctrine\Common\Collections\ArrayCollection();
        $this->show_episodes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Show
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
     * @return Show
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
     * @return Show
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
     * @return Show
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
     * Set imdb_link
     *
     * @param string $imdbLink
     * @return Show
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
     * Add show_genres
     *
     * @param \Entity\ShowGenre $showGenres
     * @return Show
     */
    public function addShowGenre(\Entity\ShowGenre $showGenres)
    {
        $this->show_genres[] = $showGenres;

        return $this;
    }

    /**
     * Remove show_genres
     *
     * @param \Entity\ShowGenre $showGenres
     */
    public function removeShowGenre(\Entity\ShowGenre $showGenres)
    {
        $this->show_genres->removeElement($showGenres);
    }

    /**
     * Get show_genres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getShowGenres()
    {
        return $this->show_genres;
    }

    /**
     * Add show_countries
     *
     * @param \Entity\ShowCountry $showCountries
     * @return Show
     */
    public function addShowCountry(\Entity\ShowCountry $showCountries)
    {
        $this->show_countries[] = $showCountries;

        return $this;
    }

    /**
     * Remove show_countries
     *
     * @param \Entity\ShowCountry $showCountries
     */
    public function removeShowCountry(\Entity\ShowCountry $showCountries)
    {
        $this->show_countries->removeElement($showCountries);
    }

    /**
     * Get show_countries
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getShowCountries()
    {
        return $this->show_countries;
    }

    /**
     * Add show_episodes
     *
     * @param \Entity\ShowEpisode $showEpisodes
     * @return Show
     */
    public function addShowEpisode(\Entity\ShowEpisode $showEpisodes)
    {
        $this->show_episodes[] = $showEpisodes;

        return $this;
    }

    /**
     * Remove show_episodes
     *
     * @param \Entity\ShowEpisode $showEpisodes
     */
    public function removeShowEpisode(\Entity\ShowEpisode $showEpisodes)
    {
        $this->show_episodes->removeElement($showEpisodes);
    }

    /**
     * Get show_episodes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getShowEpisodes()
    {
        return $this->show_episodes;
    }
}
