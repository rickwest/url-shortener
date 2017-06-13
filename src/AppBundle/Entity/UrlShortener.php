<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UrlShortener
 *
 * @ORM\Table(name="url_shortener")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UrlShortenerRepository")
 */
class UrlShortener
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, unique=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="shortCode", type="string", length=20, unique=true)
     */
    private $shortCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var integer
     *
     * @ORM\Column(name="clicks", type="integer", nullable=true)
     */
    private $clicks;

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @param string $url
     * @return UrlShortener
     */
    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getShortCode() {
        return $this->shortCode;
    }

    /**
     * @param string $shortCode
     * @return UrlShortener
     */
    public function setShortCode($shortCode) {
        $this->shortCode = $shortCode;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     * @return UrlShortener
     */
    public function setCreated($created) {
        $this->created = $created;
        return $this;
    }

    /**
     * @return int
     */
    public function getClicks() {
        return $this->clicks;
    }

    /**
     * @param int $clicks
     * @return UrlShortener
     */
    public function setClicks($clicks) {
        $this->clicks = $clicks;
        return $this;
    }
}

