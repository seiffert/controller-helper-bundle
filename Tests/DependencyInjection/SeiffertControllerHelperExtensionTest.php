<?php

namespace Seiffert\ControllerHelperBundle\Tests\DependencyInjection;

use Seiffert\ControllerHelperBundle\DependencyInjection\SeiffertControllerHelperExtension;

/**
 * @covers Seiffert\ControllerHelperBundle\DependencyInjection\SeiffertControllerHelperExtension
 */
class SeiffertControllerHelperExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SeiffertControllerHelperExtension
     */
    private $extension;

    public function setUp()
    {
        $this->extension = new SeiffertControllerHelperExtension();
    }

    public function testInstantiation()
    {
        $this->assertinstanceOf(
            'Seiffert\ControllerHelperBundle\DependencyInjection\SeiffertControllerHelperExtension',
            $this->extension
        );

        $this->assertInstanceOf('Symfony\Component\HttpKernel\DependencyInjection\Extension', $this->extension);
    }
}
