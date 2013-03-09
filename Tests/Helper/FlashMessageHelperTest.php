<?php

namespace Seiffet\ControllerHelperBundle\Tests\Helper;

use Seiffert\ControllerHelperBundle\Helper\FlashMessageHelper;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @covers Seiffert\ControllerHelperBundle\Helper\FlashMessageHelper
 */
class FlashMessageHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FlashMessageHelper
     */
    private $helper;

    /**
     * @var Session|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockSession;

    /**
     * @var FlashBag|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockFlashBag;

    public function setUp()
    {
        $this->helper = new FlashMessageHelper($this->getMockSession());
    }

    public function tearDown()
    {
        $this->mockSession = null;
        $this->mockFlashBag = null;
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf('Seiffert\HelperBundle\HelperInterface', $this->helper);
        $this->assertInstanceOf('Seiffert\ControllerHelperBundle\Helper\FlashMessageHelper', $this->helper);
    }

    public function testHelperProvidesAddFlashMessageMethod()
    {
        $this->assertContains('addFlashMessage', $this->helper->getHelperMethodNames());
    }

    public function testThrowsExceptionWithoutSession()
    {
        $this->helper = new FlashMessageHelper();

        $this->setExpectedException('Seiffert\ControllerHelperBundle\Exception\MissingDependencyException');
        $this->helper->addFlashMessage('notice', 'test');
    }

    public function testAddFlashMessageProxiesToFlashBag()
    {
        $type = 'warning';
        $message = 'This is a test warning.';

        $this->getMockSession()
            ->expects($this->once())
            ->method('getFlashBag')
            ->will($this->returnValue($this->getMockFlashBag()));

        $this->getMockFlashBag()
            ->expects($this->once())
            ->method('add')
            ->with($type, $message);

        $this->helper->addFlashMessage($type, $message);
    }

    /**
     * @return Session|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockSession()
    {
        if (null === $this->mockSession) {
            $this->mockSession = $this->getMock(
                'Symfony\Component\HttpFoundation\Session\Session'
            );
        }

        return $this->mockSession;
    }

    /**
     * @return FlashBag|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockFlashBag()
    {
        if (null === $this->mockFlashBag) {
            $this->mockFlashBag = $this->getMock(
                'Symfony\Component\HttpFoundation\Session\Flash\FlashBag'
            );
        }

        return $this->mockFlashBag;
    }
}
