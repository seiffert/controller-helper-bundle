<?php

namespace Seiffert\ControllerHelperBundle\Tests\Helper;

use Seiffert\ControllerHelperBundle\Helper\FormHelper;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;

/**
 * @covers Seiffert\ControllerHelperBundle\Helper\FormHelper
 */
class FormHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FormHelper
     */
    private $helper;

    /**
     * @var FormFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockFormFactory;

    public function setUp()
    {
        $this->helper = new FormHelper($this->getMockFormFactory());
    }

    public function tearDown()
    {
        $this->mockFormFactory = null;
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf('Seiffert\ControllerHelperBundle\Helper\FormHelper', $this->helper);
        $this->assertInstanceOf('Seiffert\HelperBundle\HelperInterface', $this->helper);
    }

    public function testHelperProvidesCreateFormMethod()
    {
        $this->assertContains('createForm', FormHelper::getHelperMethodNames());
    }

    public function testHelperRequiresFormFactory()
    {
        $this->helper = new FormHelper();

        $this->setExpectedException('Seiffert\ControllerHelperBundle\Exception\MissingDependencyException');
        $this->helper->createForm(new DateType());
    }

    public function testCreateFormSuccess()
    {
        $type = new DateType();
        $data = array('foo');
        $options = array('bar');
        $form = 'test';

        $this->getMockFormFactory()
            ->expects($this->once())
            ->method('create')
            ->with($type, $data, $options)
            ->will($this->returnValue($form));

        $this->assertSame($form, $this->helper->createForm($type, $data, $options));
    }

    /**
     * @return FormFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockFormFactory()
    {
        if (null === $this->mockFormFactory) {
            $this->mockFormFactory = $this->getMock(
                'Symfony\Component\Form\FormFactory',
                array(),
                array(),
                '',
                false
            );
        }

        return $this->mockFormFactory;
    }
}
