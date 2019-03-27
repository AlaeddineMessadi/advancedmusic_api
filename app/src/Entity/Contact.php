<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\OwnerTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Contact
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 * @ApiResource()
 *
 * @Gedmo\Loggable()
 */
class Contact
{
    use IdTrait;
    use TimestampTrait;
    use OwnerTrait;


    /**
     * @ORM\Column(type="string", name="first_name")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     *
     * @Gedmo\Versioned
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", name="last_name")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     *
     * @Gedmo\Versioned
     */
    private $lastName;

    /**
     * @Groups({"get_labels"})
     * @Assert\Email()
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     *
     * @Gedmo\Versioned
     */
    private $primaryEmail;

    /**
     * @Groups({"get_labels"})
     * @Assert\Email()
     * @Assert\Type(type="string")
     */
    private $contactEmail;

    /**
     * @Groups({"get_labels"})
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

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getPrimaryEmail()
    {
        return $this->primaryEmail;
    }

    /**
     * @param mixed $primaryEmail
     */
    public function setPrimaryEmail($primaryEmail): void
    {
        $this->primaryEmail = $primaryEmail;
    }

    /**
     * @return mixed
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * @param mixed $contactEmail
     */
    public function setContactEmail($contactEmail): void
    {
        $this->contactEmail = $contactEmail;
    }

    /**
     * @return mixed
     */
    public function getFeedbackEmail()
    {
        return $this->feedbackEmail;
    }

    /**
     * @param mixed $feedbackEmail
     */
    public function setFeedbackEmail($feedbackEmail): void
    {
        $this->feedbackEmail = $feedbackEmail;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param mixed $website
     */
    public function setWebsite($website): void
    {
        $this->website = $website;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }


}