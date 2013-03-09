<?php

namespace Seiffert\ControllerHelperBundle\Tests\Helper;

use Seiffert\ControllerHelperBundle\Helper\SecurityHelper;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\User\User;

/**
 * @covers Seiffert\ControllerHelperBundle\Helper\SecurityHelper
 */
class SecurityHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SecurityHelper
     */
    private $helper;

    /**
     * @var SecurityContext|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockSecurityContext;

    public function setUp()
    {
        $this->helper = new SecurityHelper($this->getMockSecurityContext());
    }

    public function tearDown()
    {
        $this->mockSecurityContext = null;
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf('Seiffert\HelperBundle\HelperInterface', $this->helper);
        $this->assertInstanceOf('Seiffert\ControllerHelperBundle\Helper\SecurityHelper', $this->helper);
    }

    public function testHelperProvidesGetCurrentUserMethod()
    {
        $this->assertContains('getCurrentUser', $this->helper->getHelperMethodNames());
    }

    public function testHelperRequiresSecurityContext()
    {
        $this->helper = new SecurityHelper();

        $this->setExpectedException('Seiffert\ControllerHelperBundle\Exception\MissingDependencyException');

        $this->helper->getCurrentUser();
    }

    public function testGetCurrentUserRequiresToken()
    {
        $this->getMockSecurityContext()
            ->expects($this->once())
            ->method('getToken')
            ->will($this->returnValue(null));

        $this->setExpectedException('Seiffert\ControllerHelperBundle\Exception\NotAuthenticatedException');
        $this->helper->getCurrentUser();
    }

    public function testGetCurrentUserSuccess()
    {
        $token = $this->getMock(
            'Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken',
            array('getUser'),
            array(),
            '',
            false
        );

        $this->getMockSecurityContext()
            ->expects($this->atLeastOnce())
            ->method('getToken')
            ->will($this->returnValue($token));

        $user = new User('foo', 'bar');
        $token->expects($this->once())
            ->method('getUser')
            ->will($this->returnValue($user));

        $this->assertSame($user, $this->helper->getCurrentUser());
    }

    /**
     * @return SecurityContext|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockSecurityContext()
    {
        if (null === $this->mockSecurityContext) {
            $this->mockSecurityContext = $this->getMock(
                'Symfony\Component\Security\Core\SecurityContext',
                array('getToken'),
                array(),
                '',
                false
            );
        }

        return $this->mockSecurityContext;
    }
}
