<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProfileFixtures extends BaseFixtures implements FixtureGroupInterface
{

    /**
     * @var User $user
     */
    private $user;

    protected function loadData(ObjectManager $manager)
    {
        $this->user = $manager->getRepository(User::class)->findByUserOrEmail('admin@admin.com','admin@admin.com');

        $this->createMany(Profile::class, 50, function(Profile $profile, $count) {

            $profile->setFirstName($this->faker->firstName);
            $profile->setLastName($this->faker->lastName);
            $profile->setPatronymic($this->faker->title);
            $profile->setCitizenship($this->faker->country);
            $profile->setDocument('passport');
            $profile->setNumber($this->faker->phoneNumber);
            $profile->setBirthday(New \DateTime($this->faker->date($format = 'Y-m-d', $max = 'now')));
            $profile->setCreatedBy($this->user);
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
        return ['profiles', 'labels'];
    }
}