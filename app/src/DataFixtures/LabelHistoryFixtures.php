<?php

namespace App\DataFixtures;

use App\Entity\LabelHistory;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LabelHistoryFixtures extends BaseFixtures implements FixtureGroupInterface
{

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(LabelHistory::class, 100, function(LabelHistory $labelHistory, $count) {
            $labelHistory->setApprovalRequested($this->faker->boolean);
            $labelHistory->setContactReceived($this->faker->boolean);
            $labelHistory->setDistributionLabel($this->faker->boolean);
            $labelHistory->setInformationAccepted($this->faker->boolean);
            $labelHistory->setLabelApproved($this->faker->boolean);
            $labelHistory->setLogoApproved($this->faker->boolean);
            $labelHistory->setTransferSheetReceived($this->faker->boolean);
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