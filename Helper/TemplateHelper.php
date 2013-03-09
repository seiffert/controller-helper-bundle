<?php

namespace Seiffert\ControllerHelperBundle\Helper;

use Seiffert\ControllerHelperBundle\Exception\MissingDependencyException;
use Seiffert\HelperBundle\HelperInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

class TemplateHelper implements HelperInterface
{
    /**
     * @var EngineInterface
     */
    private $templatingEngine;

    /**
     * @param EngineInterface $templatingEngine
     */
    public function __construct(EngineInterface $templatingEngine = null)
    {
        $this->templatingEngine = $templatingEngine;
    }

    /**
     * @return string[]|array
     */
    public function getHelperMethodNames()
    {
        return array('render');
    }

    /**
     * @param string $template
     * @param array $arguments
     * @param Response $response
     * @return Response
     * @throw MissingDependencyException
     */
    public function render($template, $arguments = array(), Response $response = null)
    {
        if (null === $this->templatingEngine) {
            throw new MissingDependencyException('No templating engine present.');
        }

        return $this->templatingEngine->renderResponse($template, $arguments, $response);
    }

    /**
     * @param string $template
     * @param array $arguments
     * @return string
     * @throws MissingDependencyException
     */
    public function renderView($template, $arguments = array())
    {
        if (null === $this->templatingEngine) {
            throw new MissingDependencyException('No templating engine present.');
        }

        return $this->templatingEngine->render($template, $arguments);
    }
}
