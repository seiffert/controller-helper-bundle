<?php

namespace Seiffert\ControllerHelperBundle\Helper;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Seiffert\HelperBundle\HelperInterface;

class DoctrineHelper implements HelperInterface
{
    /**
     * @var ObjectManager
     */
    private $entityManager;

    /**
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager = null)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return string[]|array
     */
    public static function getHelperMethodNames()
    {
        return array('getEntityManager', 'persist', 'flush', 'getRepository');
    }

    /**
     * @return ObjectManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param mixed $entity
     */
    public function persist($entity)
    {
        $this->entityManager->persist($entity);
    }

    /**
     * @param mixed $entity
     */
    public function flush($entity = null)
    {
        $this->entityManager->flush($entity);
    }

    /**
     * @param string $entity
     * @return ObjectRepository
     */
    public function getRepository($entity)
    {
        return $this->entityManager->getRepository($entity);
    }
}
