<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tvshow_episode_link")
 */
class EpisodeLink
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
     * @ORM\ManyToOne(targetEntity="ShowEpisode", inversedBy="links")
     * @ORM\JoinColumn(name="episode_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    public $episode;

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
     * @return EpisodeLink
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
     * @return EpisodeLink
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
     * Set episode
     *
     * @param \Entity\ShowEpisode $episode
     * @return EpisodeLink
     */
    public function setEpisode(\Entity\ShowEpisode $episode = null)
    {
        $this->episode = $episode;

        return $this;
    }

    /**
     * Get episode
     *
     * @return \Entity\ShowEpisode 
     */
    public function getEpisode()
    {
        return $this->episode;
    }
}
