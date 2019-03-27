<?php
declare(strict_types=1);
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LabelRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ApiResource()
 *
 * @Gedmo\Loggable()
 */
class Label
{
    use IdTrait;
    use TimestampTrait;



    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     *
     * @Gedmo\Versioned()
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     *
     * Biography Maximum 50 words
     */
    private $description;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank()
     */
    private $distribution;


    /**
     * 1- LabelHistory Entity OneToOne  // DONE
     * 2- Artists Entity ManyToMany
     * 3- Label Logos OneToMany
     *
     *
     */

    /** ---------------RELATIONS--------------- */

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User",  inversedBy="labels")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * Many Users have Many Groups.
     * @ORM\ManyToOne(targetEntity="App\Entity\Contact")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    private $country;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\LabelHistory")
     * @ORM\JoinColumn(name="label_history_id", referencedColumnName="id")
     */
    private $labelHistory;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\SocialNetworks")
     * @ORM\JoinColumn(name="social_networks_id", referencedColumnName="id")
     */
    private $socialNetworks;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Entity\File", mappedBy="label", cascade={"all"})
     */
    private $files;

    /** -------------End RELATIONS------------- */


    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Label
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param string $title
     * @return Label
     */
    public function setName(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->title;
    }

    /**
     * @param string $description
     * @return Label
     */
    public function setDescription(string $description):self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param mixed $contact
     */
    public function setContact($contact): void
    {
        $this->contact = $contact;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return bool
     */
    public function isDistribution(): bool
    {
        return $this->distribution;
    }

    /**
     * @param bool $distribution
     */
    public function setDistribution(bool $distribution): void
    {
        $this->distribution = $distribution;
    }

    /**
     * @return mixed
     */
    public function getLabelHistory()
    {
        return $this->labelHistory;
    }

    /**
     * @param mixed $labelHistory
     */
    public function setLabelHistory($labelHistory): void
    {
        $this->labelHistory = $labelHistory;
    }

    /**
     * @return mixed
     */
    public function getSocialNetworks()
    {
        return $this->socialNetworks;
    }

    /**
     * @param mixed $socialNetworks
     */
    public function setSocialNetworks($socialNetworks): void
    {
        $this->socialNetworks = $socialNetworks;
    }

    /**
     * @return Collection
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    /**
     * @param Collection $files
     * @return Label
     */
    public function setFiles(Collection $files): Label
    {
        $this->files = $files;
        return $this;
    }
}
