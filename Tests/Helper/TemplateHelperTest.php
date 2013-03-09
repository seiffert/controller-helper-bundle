<?php

namespace Seiffert\ControllerHelperBundle\Tests\Helper;

use Seiffert\ControllerHelperBundle\Helper\TemplateHelper;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers Seiffert\ControllerHelperBundle\Helper\TemplateHelper
 */
class TemplateHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TemplateHelper
     */
    private $helper;

    /**
     * @var EngineInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockTemplatingEngine;

    public function setUp()
    {
        $this->helper = new TemplateHelper($this->getMockTemplatingEngine());
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf('Seiffert\HelperBundle\HelperInterface', $this->helper);
        $this->assertInstanceOf('Seiffert\ControllerHelperBundle\Helper\TemplateHelper', $this->helper);
    }

    public function testHelperHasRenderResponseMethod()
    {
        $this->assertContains('render', $this->helper->getHelperMethodNames());
    }

    public function testRenderCallsTemplatingEngine()
    {
        $template = 'test';
        $variables = array('foo' => 'bar');
        $response = new Response();

        $this->getMockTemplatingEngine()
            ->expects($this->once())
            ->method('renderResponse')
            ->with($template, $variables, $response)
            ->will($this->returnValue($response));

        $this->assertSame($response, $this->helper->render($template, $variables, $response));
    }

    public function testRenderRequiresTemplatingEngine()
    {
        $this->helper = new TemplateHelper();

        $this->setExpectedException('Seiffert\ControllerHelperBundle\Exception\MissingDependencyException');
        $this->helper->render('foo');
    }

    /**
     * @return EngineInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockTemplatingEngine()
    {
        if (null === $this->mockTemplatingEngine) {
            $this->mockTemplatingEngine = $this->getMock(
                'Symfony\Bundle\FrameworkBundle\Templating\EngineInterface'
            );
        }

        return $this->mockTemplatingEngine;
    }
}
