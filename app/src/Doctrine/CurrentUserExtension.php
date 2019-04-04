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
use App\Entity\LabelHistory;
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
        User::class,
        Country::class,
        InvalidToken::class

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

        if (!in_array($resourceClass, self::ENTITIES)
            // todo uncomment the ROLE_ADMIN later
            // && !$this->authorizationChecker->isGranted('ROLE_ADMIN')
        ) {
            $rootAlias = $queryBuilder->getRootAliases()[0];
            if ($resourceClass != User::class) {
                $queryBuilder->andWhere(sprintf('%s.createdBy = :current_user', $rootAlias));
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
        /**
         * @var Entity
         */
        $entity = $args->getObject();
        $tokenStorage = $this->tokenStorage->getToken();
        if (!in_array(get_class($entity), self::ENTITIES)
            && !$this->authorizationChecker->isGranted('ROLE_ADMIN')
        ) {
            if ($tokenStorage) {
                $user = $tokenStorage->getUser();
                $entity->setCreatedBy($user);
            }
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!in_array(get_class($entity), self::ENTITIES)
            && !$this->authorizationChecker->isGranted('ROLE_ADMIN')
        ) {
            $tokenStorage = $this->tokenStorage->getToken();
            if ($tokenStorage) {
                $user = $tokenStorage->getUser();
                $entity->setUpdatedBy($user);
            }
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
            Events::preUpdate
        );
    }
}
