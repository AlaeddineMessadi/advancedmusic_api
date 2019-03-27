<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Country;
use App\Entity\Label;
use App\Entity\LabelHistory;
use App\Entity\Logos;
use App\Entity\SocialNetworks;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LabelsFixtures extends BaseFixtures implements FixtureGroupInterface, DependentFixtureInterface
{
    private $user1;
    private $users;
    private $countries;
    private $contacts;
    private $socialNetworks;
    private $logos;
    private $labelHistories;

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

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ContactFixtures::class,
            CountryFixtures::class,
            SocialNetworksFixtures::class,
            LogosFixtures::class,
            LabelHistoryFixtures::class
        ];
    }

    protected function loadData(ObjectManager $manager)
    {

        $this->user1 = $manager->getRepository(User::class)->findByUserOrEmail('admin@admin.com', 'admin@admin.com');
//        $this->users = $manager->getRepository(User::class)->findAll();
        $this->countries = $manager->getRepository(Country::class)->findAll();
        $this->contacts = $manager->getRepository(Contact::class)->findAll();
        $this->socialNetworks = $manager->getRepository(SocialNetworks::class)->findAll();
        $this->logos = $manager->getRepository(Logos::class)->findAll();
        $this->labelHistories = $manager->getRepository(LabelHistory::class)->findAll();

        // for user admin
        $this->createMany(Label::class, 100, function (Label $label, $count) {
            $country = $this->faker->randomElement($this->countries);
            $contact = $this->faker->randomElement($this->contacts);

            shuffle($this->socialNetworks);
            $socialNetwork = array_pop($this->socialNetworks);

            shuffle($this->logos);
            $logo = array_pop($this->logos);

            shuffle($this->labelHistories);
            $labelHistory = array_pop($this->labelHistories);

            $label->setName($this->faker->company);
            $label->setDescription($this->faker->text(49));
            $label->setDistribution($this->faker->boolean);
            $label->setTitle($this->faker->name);
            $label->setContact($contact);
            $label->setCountry($country);
            $label->setLabelHistory($labelHistory);
            $label->setLogos($logo);
            $label->setSocialNetworks($socialNetwork);
            $label->setUser($this->user1);
        });

            $manager->flush();
    }
}