<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Country;
use App\Utils\Tools;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AddressFixtures extends BaseFixtures implements FixtureGroupInterface, DependentFixtureInterface
{
    private $countries = [];

    /**
     * This method must return an array of groups
     * on which the implementing class belongs to
     *
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['addresses','profiles'];
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            CountryFixtures::class
        ];
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->countries = $manager->getRepository(Country::class)->findAll();

        $this->createMany(Address::class, 100, function(Address $address, $count) {
            $country = $this->faker->randomElement($this->countries);

            $address->setStreet($this->faker->streetName);
            $address->setNumber($this->faker->buildingNumber);
            $address->setZipCode((integer)$this->faker->postcode);
            $address->setCity($this->faker->city);
            $address->setCountry($country);
        });
        $manager->flush();
    }
}