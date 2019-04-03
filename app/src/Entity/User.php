<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ApiResource(
 *     attributes={
 *          "access_control"="is_granted('ROLE_ADMIN')",
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
class User extends BaseUser
{
    use TimestampTrait;


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     */
    protected $id;
    
    /**
     * @Assert\NotBlank()
     *
     * @Gedmo\Versioned
     */
    protected $username;

    /**
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    protected $email;


    /** ---------------RELATIONS--------------- */

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Label", mappedBy="user")
     */
    private $labels;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Address")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     *
     * @var $address Address
     */
    private $address;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Profile", inversedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
     */
    private $profile;


    public function __construct()
    {
        $this->labels = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return ArrayCollection|null
     */
    public function getLabels():? array
    {
        return $this->labels->toArray();
    }
    
    /**
     * @param ArrayCollection $labels
     * @return User
     */
    public function setLabels($labels): User
    {
        $this->labels = $labels;
        
        return $this;
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
    
    /**
     * @return Address|null
     */
    public function getAddress():? Address
    {
        return $this->address;
    }
    
    /**
     * @param Address|null $address
     * @return User
     */
    public function setAddress(Address $address): User
    {
        $this->address = $address;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @param string $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }
    
    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * @param string $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }
    
    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }
    
    /**
     * @param array $roles
     *
     * @return User
     */
    public function setRoles(array $roles): User
    {
        $this->roles = $roles;
        
        return $this;
    }


}
