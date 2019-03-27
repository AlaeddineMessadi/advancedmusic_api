<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Country;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CountryFixtures extends Fixture implements FixtureGroupInterface
{
    /**
     * @var User $user
     */
//    private $user;

    public function load(ObjectManager $manager)
    {
//        $this->user = $manager->getRepository(User::class)->findByUserOrEmail('admin@admin.com','admin@admin.com');
        $countriesJson = file_get_contents(__DIR__ . "/countries.json");
        $countries = json_decode($countriesJson);

        foreach ($countries as $country) {

            $country1 = new Country();
            $country1->setCode($country->code);
            $country1->setName($country->name);
//            $country1->setCreatedBy($this->user);
            $manager->persist($country1);
            $manager->flush();
        }
    }

    /**
     * This method must return an array of groups
     * on which the implementing class belongs to
     *
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['addresses', 'country', 'profiles', 'labels'];
    }
}