<?php

namespace Seiffert\ControllerHelperBundle\Helper;

use Seiffert\ControllerHelperBundle\Exception\MissingDependencyException;
use Seiffert\ControllerHelperBundle\Exception\NotAuthenticatedException;
use Seiffert\HelperBundle\HelperInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityHelper implements HelperInterface
{
    /**
     * @var SecurityContextInterface
     */
    private $securityContext;

    /**
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(SecurityContextInterface $securityContext = null)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @return string[]|array
     */
    public static function getHelperMethodNames()
    {
        return array('getCurrentUser', 'isGranted');
    }

    /**
     * @return UserInterface
     * @throws MissingDependencyException
     * @throws NotAuthenticatedException
     */
    public function getCurrentUser()
    {
        if (null === $this->securityContext) {
            throw new MissingDependencyException('No security context present.');
        }

        if (!$this->securityContext->getToken()) {
            throw new NotAuthenticatedException('User not authenticated.');
        }

        return $this->securityContext->getToken()->getUser();
    }

    /**
     * @param mixed $attributes
     * @param object $object
     * @return bool
     * @throws MissingDependencyException
     * @throws NotAuthenticatedException
     */
    public function isGranted($attributes, $object = null)
    {
        if (null === $this->securityContext) {
            throw new MissingDependencyException('No security context present.');
        }

        if (!$this->securityContext->getToken()) {
            throw new NotAuthenticatedException('User not authenticated.');
        }

        return $this->securityContext->isGranted($attributes, $object);
    }
}
