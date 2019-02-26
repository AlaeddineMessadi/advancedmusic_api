<?php

namespace App\Entity\Constants;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Constants\CountryRepository")
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var $name string Country name
     *
     * @ORM\Column(name="name", type="string", length=25)
     */
    private $name;

    /**
     * @var $code string country code
     *
     * @ORM\Column(name="code", type="string", length=2)
     */
    private $code;
}
