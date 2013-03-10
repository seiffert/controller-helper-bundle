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
        return array('getCurrentUser');
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
}
