<?php

namespace Seiffert\ControllerHelperBundle\Helper;

use Seiffert\ControllerHelperBundle\Exception\MissingDependencyException;
use Seiffert\HelperBundle\HelperInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class FlashMessageHelper implements HelperInterface
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @param Session $session
     */
    public function __construct(Session $session = null)
    {
        $this->session = $session;
    }

    /**
     * @return string[]|array
     */
    public static function getHelperMethodNames()
    {
        return array('addFlashMessage');
    }

    /**
     * @param string $type
     * @param string $message
     * @throws MissingDependencyException
     */
    public function addFlashMessage($type, $message)
    {
        if (null === $this->session) {
            throw new MissingDependencyException('No session present.');
        }

        $this->session->getFlashBag()->add($type, $message);
    }
}
