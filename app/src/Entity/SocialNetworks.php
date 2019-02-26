<?php

namespace App\Entity;


use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SocialNetworksRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class SocialNetworks
{

    use IdTrait;
    use TimestampTrait;

    /**
     * @ORM\Column(type="string")
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $facebook;

    /**
     * @ORM\Column(type="string")
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $soundCloud;

    /**
     * @ORM\Column(type="string")
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $youtube;

    /**
     * @ORM\Column(type="string")
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $twitter;

    /**
     * @ORM\Column(type="string")
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $rss;

    /**
     * @ORM\Column(type="string")
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $instagram;

    /**
     * @ORM\Column(type="string")
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $spotify;

    /**
     * @return mixed
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param mixed $facebook
     */
    public function setFacebook($facebook): void
    {
        $this->facebook = $facebook;
    }

    /**
     * @return mixed
     */
    public function getSoundCloud()
    {
        return $this->soundCloud;
    }

    /**
     * @param mixed $soundCloud
     */
    public function setSoundCloud($soundCloud): void
    {
        $this->soundCloud = $soundCloud;
    }

    /**
     * @return mixed
     */
    public function getYoutube()
    {
        return $this->youtube;
    }

    /**
     * @param mixed $youtube
     */
    public function setYoutube($youtube): void
    {
        $this->youtube = $youtube;
    }

    /**
     * @return mixed
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @param mixed $twitter
     */
    public function setTwitter($twitter): void
    {
        $this->twitter = $twitter;
    }

    /**
     * @return mixed
     */
    public function getRss()
    {
        return $this->rss;
    }

    /**
     * @param mixed $rss
     */
    public function setRss($rss): void
    {
        $this->rss = $rss;
    }

    /**
     * @return mixed
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * @param mixed $instagram
     */
    public function setInstagram($instagram): void
    {
        $this->instagram = $instagram;
    }

    /**
     * @return mixed
     */
    public function getSpotify()
    {
        return $this->spotify;
    }

    /**
     * @param mixed $spotify
     */
    public function setSpotify($spotify): void
    {
        $this->spotify = $spotify;
    }

}