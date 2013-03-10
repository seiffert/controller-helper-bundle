<?php

namespace Seiffert\ControllerHelperBundle\Tests\Helper;

use Seiffert\ControllerHelperBundle\Helper\TemplateHelper;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        $this->assertContains('render', TemplateHelper::getHelperMethodNames());
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

    public function testRenderViewCallsTemplatingEngine()
    {
        $template = 'test';
        $variables = array('foo' => 'bar');
        $result = 'testfoobar';

        $this->getMockTemplatingEngine()
            ->expects($this->once())
            ->method('render')
            ->with($template, $variables)
            ->will($this->returnValue($result));

        $this->assertSame($result, $this->helper->renderView($template, $variables));
    }

    public function testRenderViewRequiresTemplatingEngine()
    {
        $this->helper = new TemplateHelper();

        $this->setExpectedException('Seiffert\ControllerHelperBundle\Exception\MissingDependencyException');
        $this->helper->renderView('foo');
    }

    public function testStreamReturnsResponse()
    {
        $response = new StreamedResponse();
        $this->assertSame($response, $this->helper->stream('foo', array(), $response));
    }

    public function testStreamRequiresTemplatingEngine()
    {
        $this->helper = new TemplateHelper();

        $this->setExpectedException('Seiffert\ControllerHelperBundle\Exception\MissingDependencyException');
        $this->helper->stream('foo');
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
