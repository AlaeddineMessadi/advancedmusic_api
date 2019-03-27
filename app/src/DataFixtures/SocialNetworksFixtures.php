<?php

namespace App\DataFixtures;

use App\Entity\SocialNetworks;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SocialNetworksFixtures extends BaseFixtures implements FixtureGroupInterface
{

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(SocialNetworks::class, 50, function(SocialNetworks $socialNetworks, $count) {
            $socialNetworks->setFacebook($this->faker->url);
            $socialNetworks->setInstagram($this->faker->url);
            $socialNetworks->setRss($this->faker->url);
            $socialNetworks->setSoundCloud($this->faker->url);
            $socialNetworks->setSpotify($this->faker->url);
            $socialNetworks->setTwitter($this->faker->url);
            $socialNetworks->setYoutube($this->faker->url);
        });

        $manager->flush();
    }

    /**
     * This method must return an array of groups
     * on which the implementing class belongs to
     *
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['labels'];
    }
}