<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\CreatedByTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\OwnerTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @ApiResource(
 *     attributes={
 *          "access_control"="is_granted('ROLE_USER')",
 *          "normalization_context"={
 *                 "groups"={"read"},
 *                 "datetime_format"="d.m.Y H:i:s"
 *          },
 *          "denormalization_context"={
 *                  "groups"={"write"},
 *                  "datetime_format"="d.m.Y H:i:s"
 *          }
 *     }
 * )
 *
 * @Gedmo\Loggable()
 */
class Profile
{
    use IdTrait;
    use TimestampTrait;
    use OwnerTrait;


    /**
     * @ORM\Column(type="string", name="first_name")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     *
     * @Groups({"read", "write"})
     *
     * @Gedmo\Versioned()
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", name="last_name")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     *
     * @Groups({"read", "write"})
     */
    private $lastName;
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Type(type="string")
     *
     * @Groups({"read", "write"})
     */
    private $patronymic;
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     *
     * @Groups({"read", "write"})
     */
    private $citizenship;
    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     *
     * @Groups({"read", "write"})
     */
    private $document;
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $number;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Date()
     *
     * @Groups({"read", "write"})
     */
    private $birthday;

    /** ---------------RELATIONS--------------- */

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="profile")
     * @Groups({"read"})
     */
    private $user;

    /** -------------End RELATIONS------------- */



    /**
     * @return User|null
     */
    public function getUser():? User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Profile
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }


    /**
     * @param string $firstName
     * @return Profile
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $lastName
     * @return Profile
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $patronymic
     * @return Profile
     */
    public function setPatronymic(string $patronymic): self
    {
        $this->patronymic = $patronymic;
        return $this;
    }

    /**
     * @return string
     */
    public function getPatronymic(): string
    {
        return $this->patronymic;
    }

    /**
     * @param string $citizenship
     * @return Profile
     */
    public function setCitizenship(string $citizenship): self
    {
        $this->citizenship = $citizenship;
        return $this;
    }

    /**
     * @return string
     */
    public function getCitizenship(): string
    {
        return $this->citizenship;
    }

    /**
     * @param string $document
     * @return Profile
     */
    public function setDocument(string $document): self
    {
        $this->document = $document;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocument(): string
    {
        return $this->document;
    }

    /**
     * @param string $number
     * @return Profile
     */
    public function setNumber(string $number): self
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param \DateTime $birthday
     * @return Profile
     */
    public function setBirthday(\DateTime $birthday): self
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBirthday(): \DateTime
    {
        return $this->birthday;
    }


    public  function getFullName(): String
    {
        return "$this->getFirstName() $this->getLastName()";
    }

}
