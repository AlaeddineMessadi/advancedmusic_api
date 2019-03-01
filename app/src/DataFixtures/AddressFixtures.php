<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AddressFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 2; $i++) {

            $country1 = $manager->getRepository(Country::class)->findOneBy(['name' => 'Germany']);
            $country2 = $manager->getRepository(Country::class)->findOneBy(['name' => 'Tunisia']);
            
            $entity = new Address();
            $entity->setStreet('OranientStr' . $i);
            $entity->setNumber('197');
            $entity->setZipCode('10999' . $i);
            $entity->setCity('Berlin');
            $entity->setCountry($country1);
    
            $entity1 = new Address();
            $entity1->setStreet('Rue morocco' . $i);
            $entity1->setNumber('100');
            $entity1->setZipCode('8024' . $i);
            $entity1->setCity('Tazarka');
            $entity1->setCountry($country2);

            $manager->persist($entity);
            $manager->flush();
        }
    }
}