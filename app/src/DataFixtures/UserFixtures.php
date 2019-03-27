<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Profile;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFixtures extends BaseFixtures implements ContainerAwareInterface, FixtureInterface, DependentFixtureInterface, FixtureGroupInterface
{
    const USERS = [
        [
            'username' => 'user',
            'email' => 'user@user.com',
            'password' => 'user',
            'role' => 'ROLE_USER'

        ],
        [
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'firstName' => 'Admin',
            'password' => 'admin',
            'role' => 'ROLE_ADMIN'
        ]
    ];

    /**
     * @var array $profiles
     */
    private $profiles;

    /**
     * @var array $addresses
     */
    private $addresses;
    /**
     * @var Container
     */
    private $container;

    /**
     * @var mixed
     */
    private $encoder;
    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            ProfileFixtures::class,
            AddressFixtures::class
        ];
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->profiles = $manager->getRepository(Profile::class)->findAll();
        $this->addresses = $manager->getRepository(Address::class)->findAll();

        foreach (self::USERS as $user) {
            shuffle($this->profiles);
            $profile = array_pop($this->profiles);

            shuffle($this->addresses);
            $address = array_pop($this->addresses);

            $entity = new User();
            $entity->setProfile($profile);
            $entity->setAddress($address);

            $entity->setEmail($user['email']);
            $entity->setUsername($user['username']);
            $entity->setEnabled(true);

            $password = $this->encoder->encodePassword($entity, $user['password']);
            $entity->addRole($user['role']);
            $entity->setPassword($password);

            $manager->persist($entity);
            $manager->flush();
        }



        $this->createMany(User::class, 5, function (User $user, $count) {
            shuffle($this->profiles);
            $profile = array_pop($this->profiles);

            shuffle($this->addresses);
            $address = array_pop($this->addresses);

            $user->setUsername($this->faker->userName);
            $user->setEmail($this->faker->email);
            $user->setProfile($profile);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->encoder->encodePassword($user, 'user'));
            $user->setAddress($address);

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

    /**
     * Sets the container.
     * @param ContainerInterface|null $container
     * @throws \Exception
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->encoder = $this->container->get('security.password_encoder');
    }
}