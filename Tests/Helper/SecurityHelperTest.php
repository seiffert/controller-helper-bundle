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
        $this->helper = null;
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf('Seiffert\HelperBundle\HelperInterface', $this->helper);
        $this->assertInstanceOf('Seiffert\ControllerHelperBundle\Helper\SecurityHelper', $this->helper);
    }

    public function testHelperProvidesGetCurrentUserMethod()
    {
        $this->assertContains('getCurrentUser', SecurityHelper::getHelperMethodNames());
    }

    public function testHelperProvidesIsGrantedMethod()
    {
        $this->assertContains('isGranted', SecurityHelper::getHelperMethodNames());
    }

    public function testGetCurrentUserRequiresSecurityContext()
    {
        $this->helper = new SecurityHelper();

        $this->setExpectedException('Seiffert\ControllerHelperBundle\Exception\MissingDependencyException');

        $this->helper->getCurrentUser();
    }

    public function testIsGrantedRequiresSecurityContext()
    {
        $this->helper = new SecurityHelper();

        $this->setExpectedException('Seiffert\ControllerHelperBundle\Exception\MissingDependencyException');

        $this->helper->isGranted('ROLE_USER');
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

    public function testIsGrantedRequiresToken()
    {
        $this->getMockSecurityContext()
            ->expects($this->once())
            ->method('getToken')
            ->will($this->returnValue(null));

        $this->setExpectedException('Seiffert\ControllerHelperBundle\Exception\NotAuthenticatedException');
        $this->helper->isGranted('ROLE_USER');
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

    public function testIsGranted()
    {
        $item = 'ROLE_USER';

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

        $this->getMockSecurityContext()
            ->expects($this->any())
            ->method('isGranted')
            ->with($item, null)
            ->will($this->returnValue(true));

        $this->assertTrue($this->helper->isGranted($item));
    }

    /**
     * @return SecurityContext|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockSecurityContext()
    {
        if (null === $this->mockSecurityContext) {
            $this->mockSecurityContext = $this->getMock(
                'Symfony\Component\Security\Core\SecurityContextInterface',
                array('getToken', 'isGranted', 'setToken'),
                array(),
                '',
                false
            );
        }

        return $this->mockSecurityContext;
    }
}
