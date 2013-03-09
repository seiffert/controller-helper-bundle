<?php

namespace Seiffert\ControllerHelperBundle\Tests;

use Seiffert\ControllerHelperBundle\SeiffertControllerHelperBundle;

/**
 * @covers Seiffert\ControllerHelperBundle\SeiffertControllerHelperBundle;
 */
class SeiffertControllerHelperBundleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SeiffertControllerHelperBundle
     */
    private $bundle;

    public function setUp()
    {
        $this->bundle = new SeiffertControllerHelperBundle();
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf('Symfony\Component\HttpKernel\Bundle\Bundle', $this->bundle);
        $this->assertInstanceOf('Seiffert\ControllerHelperBundle\SeiffertControllerHelperBundle', $this->bundle);
    }
}
