<?php

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Contact
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Contact
{
    use IdTrait;
    use TimestampTrait;


    /**
     * @ORM\Column(type="string", name="first_name")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", name="last_name")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $lastName;

    /**
     * @Serializer\Groups({"get_labels"})
     * @Assert\Email()
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $primaryEmail;

    /**
     * @Serializer\Groups({"get_labels"})
     * @Assert\Email()
     * @Assert\Type(type="string")
     */
    private $contactEmail;

    /**
     * @Serializer\Groups({"get_labels"})
     * @Assert\Email()
     * @Assert\Type(type="string")
     */
    private $feedbackEmail;

    /**
     * @ORM\Column(type="string")
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $website;

    /**
     * @ORM\Column(type="string")
     * @Assert\Url()
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $phoneNumber;
}