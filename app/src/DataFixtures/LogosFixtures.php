<?php

namespace App\DataFixtures;

use App\Entity\Files;
use App\Entity\Logos;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LogosFixtures extends BaseFixtures implements FixtureGroupInterface
{

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Logos::class, 100, function(Logos $logos, $count) {
            $file = new Files();
            $logos->setLogoBig($file);
            $logos->setLogoMedium($file);
            $logos->setLogoSmall($file);
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