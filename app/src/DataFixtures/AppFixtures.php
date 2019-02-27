<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppFixtures extends Fixture implements ContainerAwareInterface
{
    public function load(ObjectManager $manager)
    {
//        $this->loadUsers($manager);
//        $this->loadBooks($manager);
    }

	private function loadBooks(ObjectManager $manager)
	{
		for ($i = 0; $i < 20; $i++) {
			$book = new Book();
			$book->setTitle('Foo bar'. $i);
			$book->setPrice(mt_rand(10, 100));
			$manager->persist($book);
		}

		$manager->flush();
	}

	private function loadUsers(ObjectManager $manager)
    {
        $passwordEncoder = $this->container->get('security.password_encoder');
        $userAdmin = new User();
        $userAdmin->setName('tony');
        $userAdmin->setSurname('master');
        $userAdmin->setUsername('tony_admin');
        $userAdmin->setEmail('tony_admin@symfony.com');
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $encodedPassword = $passwordEncoder->encodePassword($userAdmin, 'admin');
        $userAdmin->setPassword($encodedPassword);
        $manager->persist($userAdmin);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null): void
    {
        $this->container = $container;
    }
}
