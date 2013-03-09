<?php

namespace Seiffert\ControllerHelperBundle\Tests\Helper;

use Seiffert\ControllerHelperBundle\Helper\RouterHelper;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @covers Seiffert\ControllerHelperBundle\Tests\Helper\RouterHelper
 */
class RouterHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RouterHelper
     */
    private $helper;

    /**
     * @var Router|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockRouter;

    public function setUp()
    {
        $this->helper = new RouterHelper($this->getMockRouter());
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf('Seiffert\HelperBundle\HelperInterface', $this->helper);
        $this->assertInstanceOf('Seiffert\ControllerHelperBundle\Helper\RouterHelper', $this->helper);
    }

    public function testHasGenerateUrlHelperMethod()
    {
        $this->assertContains('generateUrl', $this->helper->getHelperMethodNames());
    }

    public function testGenerateUrlCallsRouter()
    {
        $route = 'test';
        $params = array('id' => '123');
        $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH;
        $result = 'test123';

        $this->getMockRouter()
            ->expects($this->once())
            ->method('generate')
            ->with($route, $params, $referenceType)
            ->will($this->returnValue($result));

        $url = $this->helper->generateUrl($route, $params, $referenceType);

        $this->assertEquals($result, $url);
    }

    /**
     * @return Router|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockRouter()
    {
        if (null === $this->mockRouter) {
            $this->mockRouter = $this->getMock(
                'Symfony\Bundle\FrameworkBundle\Routing\Router',
                array(),
                array(),
                '',
                false
            );
        }

        return $this->mockRouter;
    }
}
