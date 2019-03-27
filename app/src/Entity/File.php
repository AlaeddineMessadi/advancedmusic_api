<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\CreatedByTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\OwnerTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FileRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ApiResource()
 *
 * implement uploadable file doctrine extension
 * https://github.com/Atlantic18/DoctrineExtensions/blob/v2.4.x/doc/uploadable.md
 */
class File
{
    use IdTrait;
    use TimestampTrait;
    use OwnerTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Label", inversedBy="file")
     */
    private $label;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $name;
    /**
     * @ORM\Column(type="string")
     */
    private $hash;
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $description;
    /**
     * @ORM\Column(type="string")
     */
    private $type;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $code;
    /**
     * @ORM\Column(type="integer")
     */
    private $size;


    /**
     * @param int $code
     * @return File
     */
    public function setCode(int $code = null): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCode():? int
    {
        return $this->code;
    }

    /**
     * @param string $name
     * @return File
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $hash
     * @return File
     */
    public function setHash(string $hash): self
    {
        $this->hash = $hash;
        return $this;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $description
     * @return File
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $type
     * @return File
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param int $size
     * @return File
     */
    public function setSize(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     * @return File
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

}
