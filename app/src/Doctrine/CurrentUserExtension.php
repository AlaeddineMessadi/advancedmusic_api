<?php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Address;
use App\Entity\Contact;
use App\Entity\Country;
use App\Entity\File;
use App\Entity\InvalidToken;
use App\Entity\Label;
use App\Entity\Profile;
use App\Entity\SocialNetworks;
use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface, EventSubscriber
{
    private $tokenStorage;
    private $authorizationChecker;
    const ENTITIES = [
        Label::class,
        Profile::class,
        SocialNetworks::class,
        Country::class,
        Address::class,
        Contact::class,
        InvalidToken::class,
        File::class,

    ];

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $checker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $checker;
    }

    /**
     * {@inheritdoc}
     */
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     * {@inheritdoc}
     */
    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     *
     * @param QueryBuilder $queryBuilder
     * @param string $resourceClass
     */
    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        if ($user instanceof User && in_array($resourceClass, self::ENTITIES)
            && !$this->authorizationChecker->isGranted('ROLE_ADMIN')
        ) {
            $rootAlias = $queryBuilder->getRootAliases()[0];
            if ($resourceClass != User::class) {
                $queryBuilder->andWhere(sprintf('%s.createBy = :current_user', $rootAlias));
                $queryBuilder->setParameter('current_user', $user->getId());
            }

//            switch ($resourceClass) {
//                case Label::class:
//                    $queryBuilder->andWhere(sprintf('%s.user = :current_user', $rootAlias));
//                    $queryBuilder->setParameter('current_user', $user->getId());
//                    break;
//                case Profile::class:
//                    $queryBuilder->andWhere(sprintf('%s.user = :current_user', $rootAlias));
//                    $queryBuilder->setParameter('current_user', $user->getId());
//                    break;
//            }
        }
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $tokenStorage = $this->tokenStorage->getToken();
        $em = $args->getObjectManager();

        if ($tokenStorage) {
            $user = $tokenStorage->getUser();
            /**
             * @var Entity
             */
            $entity = $args->getObject();

            $entity->setCreatedBy($user);

            $em->persist($entity);
            $em->flush();
        }
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
        );
    }
}
