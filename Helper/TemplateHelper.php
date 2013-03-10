<?php

namespace Seiffert\ControllerHelperBundle\Helper;

use Seiffert\ControllerHelperBundle\Exception\MissingDependencyException;
use Seiffert\HelperBundle\HelperInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
    public static function getHelperMethodNames()
    {
        return array('render');
    }

    /**
     * @param string $template
     * @param array $arguments
     * @param Response $response
     * @return Response
     */
    public function render($template, $arguments = array(), Response $response = null)
    {
        $this->ensureTemplatingEngineIsPresent();

        return $this->templatingEngine->renderResponse($template, $arguments, $response);
    }

    /**
     * @param string $template
     * @param array $arguments
     * @return string
     */
    public function renderView($template, $arguments = array())
    {
        $this->ensureTemplatingEngineIsPresent();

        return $this->templatingEngine->render($template, $arguments);
    }

    /**
     * @param string $template
     * @param array $arguments
     * @param StreamedResponse $response
     * @return StreamedResponse
     */
    public function stream($template, $arguments = array(), StreamedResponse $response = null)
    {
        $this->ensureTemplatingEngineIsPresent();

        $templating = $this->templatingEngine;
        $callback = function () use ($templating, $template, $arguments) {
            $templating->stream($template, $arguments);
        };

        if (null === $response) {
            return new StreamedResponse($callback);
        }

        $response->setCallback($callback);

        return $response;
    }

    /**
     * @throws MissingDependencyException
     */
    private function ensureTemplatingEngineIsPresent()
    {
        if (null === $this->templatingEngine) {
            throw new MissingDependencyException('No templating engine present.');
        }
    }
}
