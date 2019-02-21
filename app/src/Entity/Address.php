<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var $street string street
     *
     * @ORM\Column(name="street", type="string", length=225)
     * @Assert\NotNull()
     *
     */
    private $street;

    /**
     * @var $number integer street number
     *
     * @ORM\Column(name="number", type="integer")
     * @Assert\NotNull()
     *
     */
    private $number;

    /**
     * @var $zipCode integer zipcode
     *
     * @ORM\Column(name="zip_code", type="integer")
     * @Assert\NotNull()
     *
     */
    private $zipCode;

    /**
     * @var $name string city
     *
     * @ORM\Column(name="city", type="string", length=115)
     * @Assert\NotNull()
     *
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    private $country;
}
