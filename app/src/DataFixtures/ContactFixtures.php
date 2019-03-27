<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\SocialNetworks;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ContactFixtures extends BaseFixtures implements FixtureGroupInterface
{

    /**
     * @var User $user
     */
    private $user;

    protected function loadData(ObjectManager $manager)
    {
        $this->user = $manager->getRepository(User::class)->findByUserOrEmail('admin@admin.com','admin@admin.com');

        $this->createMany(Contact::class, 50, function(Contact $contact, $count) {
            $contact->setFirstName($this->faker->firstName);
            $contact->setLastName($this->faker->lastName);
            $contact->setPhoneNumber($this->faker->phoneNumber);
            $contact->setPrimaryEmail($this->faker->email);
            $contact->setContactEmail($this->faker->email);
            $contact->setFeedbackEmail($this->faker->email);
            $contact->setWebsite($this->faker->url);
            $contact->setCreatedBy($this->user);
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
        return ['labels', 'contacts'];
    }
}