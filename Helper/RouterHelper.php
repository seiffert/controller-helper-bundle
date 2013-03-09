<?php

namespace Seiffert\ControllerHelperBundle\Helper;

use Seiffert\ControllerHelperBundle\Exception\MissingDependencyException;
use Seiffert\HelperBundle\HelperInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RouterHelper implements HelperInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(UrlGeneratorInterface $urlGenerator = null)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @return string[]|array
     */
    public function getHelperMethodNames()
    {
        return array('generateUrl');
    }

    /**
     * @param string $route
     * @param array $parameters
     * @param string $referenceType
     * @return string
     * @throws MissingDependencyException
     */
    public function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::RELATIVE_PATH)
    {
        if (null === $this->urlGenerator) {
            throw new MissingDependencyException('No router present.');
        }

        return $this->urlGenerator->generate($route, $parameters, $referenceType);
    }
}
