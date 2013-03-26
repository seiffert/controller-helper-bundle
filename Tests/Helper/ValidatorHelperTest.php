<?php

namespace Seiffert\ControllerHelperBundle\Tests\Helper;

use Seiffert\ControllerHelperBundle\Helper\ValidatorHelper;
use Symfony\Component\Validator\Validator;

/**
 * @covers Seiffert\ControllerHelperBundle\Helper\FormHelper
 */
class ValidatorHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ValidatorHelper
     */
    private $helper;

    /**
     * @var Validator|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockValidator;

    public function setUp()
    {
        $this->helper = new ValidatorHelper($this->getMockValidator());
    }

    public function tearDown()
    {
        $this->mockValidator = null;
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf('Seiffert\ControllerHelperBundle\Helper\ValidatorHelper', $this->helper);
        $this->assertInstanceOf('Seiffert\HelperBundle\HelperInterface', $this->helper);
    }

    public function testHelperProvidesCreateFormMethod()
    {
        $this->assertContains('validate', ValidatorHelper::getHelperMethodNames());
    }

    public function testHelperRequiresFormFactory()
    {
        $this->helper = new ValidatorHelper();

        $this->setExpectedException('Seiffert\ControllerHelperBundle\Exception\MissingDependencyException');
        $this->helper->validate(array());
    }

    public function testValidateSuccess()
    {
        $data = array('foo');

        $this->getMockValidator()
            ->expects($this->once())
            ->method('validate')
            ->with($data)
            ->will($this->returnValue(true));

        $this->assertTrue($this->helper->validate($data));
    }

    /**
     * @return Validator|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockValidator()
    {
        if (null === $this->mockValidator) {
            $this->mockValidator = $this->getMock(
                'Symfony\Component\Validator\Validator',
                array(),
                array(),
                '',
                false
            );
        }

        return $this->mockValidator;
    }
}
