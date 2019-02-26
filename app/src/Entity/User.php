<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ApiResource(
 *     attributes={
 *          "access_control"="is_granted('ROLE_ADMIN')",
 *          "normalization_context"={
 *                 "groups"={"get_users", "user-read"},
 *                 "datetime_format"="d.m.Y H:i:s"
 *          },
 *          "denormalization_context"={
 *                  "groups"={"user", "user-write"},
 *                  "datetime_format"="d.m.Y H:i:s"
 *          }
 *     }
 * )
 */
class User extends BaseUser
{
    use IdTrait;
    use TimestampTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"get_users"})
     */
    protected $id;

    /**
     * @Serializer\Groups({"get_users"})
     * @Assert\NotBlank()
     */
    protected $username;

    /**
     * @Serializer\Groups({"get_users"})
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    protected $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\labels", mappedBy="user")
     */
    private $labels;



    /** ---------------RELATIONS--------------- */
    /**
     * @ORM\OneToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     *
     * @var $address Address
     */
    private $address;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Profile", inversedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
     * @Serializer\Groups({"get_users"})
     */
    private $profile;






    /**
     * @ORM\Column(type="datetime", name="created_at")
     * @Serializer\Groups({"get_users"})
     */
    protected $createdAt;

    public function __construct()
    {
        $this->labels = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
    /**
     * @return array|null
     */
    public function getLabels():? array
    {
        return $this->labels->toArray();
    }

    /**
     * @param Profile|null $profile
     * @return User
     */
    public function setProfile(Profile $profile = null): self
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * @return Profile|null
     */
    public function getProfile():? Profile
    {
        return $this->profile;
    }

}
