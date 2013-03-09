<?php

namespace Seiffert\ControllerHelperBundle\Helper;

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
    public function __construct(UrlGeneratorInterface $urlGenerator)
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
     */
    public function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::RELATIVE_PATH)
    {
        return $this->urlGenerator->generate($route, $parameters, $referenceType);
    }
}
