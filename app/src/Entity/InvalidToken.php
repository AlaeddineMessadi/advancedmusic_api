<?php

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvalidTokenRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @Gedmo\Loggable()
 */
class InvalidToken
{
    use IdTrait;
    use BlameableEntity;

    /**
     * @ORM\Column(type="integer")
     * @Gedmo\Versioned
     */
    protected $expiration;

    /**
     * @ORM\Column(type="string", length=64)
     * @Gedmo\Versioned
     */
    protected $hash;

    /**
     * @param int $expiration
     * @return InvalidToken
     */
    function setExpiration(int $expiration): self
    {
        $this->expiration = $expiration;
        return $this;
    }

    /**
     * @return int
     */
    function getExpiration(): int
    {
        return $this->expiration;
    }

    /**
     * @param string $srcString
     * @return InvalidToken
     */
    function setHash(string $srcString): self
    {
        $this->hash = hash('sha256', $srcString, false);
        return $this;
    }

    /**
     * @return string
     */
    function getHash(): string
    {
        return $this->hash;
    }
}
