<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tvshow_episode")
 */
class ShowEpisode
{    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="integer")
     */
    public $season;

    /**
     * @ORM\Column(type="integer")
     */
    public $episode;
    
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
    public $air_date;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $updated_on;
    
    /**
     * @ORM\ManyToOne(targetEntity="Show", inversedBy="show_episodes")
     * @ORM\JoinColumn(name="show_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    public $show;
    
    /**
     * @ORM\OneToMany(targetEntity="EpisodeLink", mappedBy="episode")
     **/
    public $links;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->links = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return ShowEpisode
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
     * @return ShowEpisode
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
     * Set air_date
     *
     * @param string $airDate
     * @return ShowEpisode
     */
    public function setAirDate($airDate)
    {
        $this->air_date = $airDate;

        return $this;
    }

    /**
     * Get air_date
     *
     * @return string 
     */
    public function getAirDate()
    {
        return $this->air_date;
    }

    /**
     * Set show
     *
     * @param \Entity\Show $show
     * @return ShowEpisode
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
     * Add links
     *
     * @param \Entity\EpisodeLink $links
     * @return ShowEpisode
     */
    public function addLink(\Entity\EpisodeLink $links)
    {
        $this->links[] = $links;

        return $this;
    }

    /**
     * Remove links
     *
     * @param \Entity\EpisodeLink $links
     */
    public function removeLink(\Entity\EpisodeLink $links)
    {
        $this->links->removeElement($links);
    }

    /**
     * Get links
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Set season
     *
     * @param integer $season
     * @return ShowEpisode
     */
    public function setSeason($season)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return integer 
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set episode
     *
     * @param integer $episode
     * @return ShowEpisode
     */
    public function setEpisode($episode)
    {
        $this->episode = $episode;

        return $this;
    }

    /**
     * Get episode
     *
     * @return integer 
     */
    public function getEpisode()
    {
        return $this->episode;
    }
}
