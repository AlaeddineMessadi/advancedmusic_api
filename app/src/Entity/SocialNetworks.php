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


}