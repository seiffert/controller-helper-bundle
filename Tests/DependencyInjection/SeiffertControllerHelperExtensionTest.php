<?php

namespace Seiffert\ControllerHelperBundle\Tests\DependencyInjection;

use Seiffert\ControllerHelperBundle\DependencyInjection\SeiffertControllerHelperExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Reference;

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

    public function testExtensionProvidesRouterHelper()
    {
        $containerBuilder = new ContainerBuilder();

        $this->extension->load(array(), $containerBuilder);

        $this->assertTrue($containerBuilder->hasDefinition('seiffert.helper.controller.router'));
        $definition = $containerBuilder->getDefinition('seiffert.helper.controller.router');

        $this->assertEquals(
            'Seiffert\ControllerHelperBundle\Helper\RouterHelper',
            $containerBuilder->getParameter(str_replace('%', '', $definition->getClass()))
        );
        $this->assertCount(1, $definition->getArguments());

        $routerReference = new Reference('router', ContainerInterface::IGNORE_ON_INVALID_REFERENCE);
        $this->assertEquals($routerReference, $definition->getArgument(0));

        $tags = $definition->getTag('seiffert.helper');
        $this->assertCount(1, $tags);

        $tag = $tags[0];
        $this->assertEquals('seiffert.helper.controller', $tag['broker']);
    }

    public function testExtensionProvidesTemplateHelper()
    {
        $containerBuilder = new ContainerBuilder();

        $this->extension->load(array(), $containerBuilder);

        $this->assertTrue($containerBuilder->hasDefinition('seiffert.helper.controller.template'));
        $definition = $containerBuilder->getDefinition('seiffert.helper.controller.template');

        $this->assertEquals(
            'Seiffert\ControllerHelperBundle\Helper\TemplateHelper',
            $containerBuilder->getParameter(str_replace('%', '', $definition->getClass()))
        );
        $this->assertCount(1, $definition->getArguments());

        $routerReference = new Reference('templating', ContainerInterface::IGNORE_ON_INVALID_REFERENCE);
        $this->assertEquals($routerReference, $definition->getArgument(0));

        $tags = $definition->getTag('seiffert.helper');
        $this->assertCount(1, $tags);

        $tag = $tags[0];
        $this->assertEquals('seiffert.helper.controller', $tag['broker']);
    }

    public function testExtensionProvidesFlashMessageHelper()
    {
        $containerBuilder = new ContainerBuilder();

        $this->extension->load(array(), $containerBuilder);

        $this->assertTrue($containerBuilder->hasDefinition('seiffert.helper.controller.flash_message'));
        $definition = $containerBuilder->getDefinition('seiffert.helper.controller.flash_message');

        $this->assertEquals(
            'Seiffert\ControllerHelperBundle\Helper\FlashMessageHelper',
            $containerBuilder->getParameter(str_replace('%', '', $definition->getClass()))
        );
        $this->assertCount(1, $definition->getArguments());

        $routerReference = new Reference('session', ContainerInterface::IGNORE_ON_INVALID_REFERENCE);
        $this->assertEquals($routerReference, $definition->getArgument(0));

        $tags = $definition->getTag('seiffert.helper');
        $this->assertCount(1, $tags);

        $tag = $tags[0];
        $this->assertEquals('seiffert.helper.controller', $tag['broker']);
    }

    public function testExtensionProvidesSecurityHelper()
    {
        $containerBuilder = new ContainerBuilder();

        $this->extension->load(array(), $containerBuilder);

        $this->assertTrue($containerBuilder->hasDefinition('seiffert.helper.controller.security'));
        $definition = $containerBuilder->getDefinition('seiffert.helper.controller.security');

        $this->assertEquals(
            'Seiffert\ControllerHelperBundle\Helper\SecurityHelper',
            $containerBuilder->getParameter(str_replace('%', '', $definition->getClass()))
        );
        $this->assertCount(1, $definition->getArguments());

        $routerReference = new Reference('security.context', ContainerInterface::IGNORE_ON_INVALID_REFERENCE);
        $this->assertEquals($routerReference, $definition->getArgument(0));

        $tags = $definition->getTag('seiffert.helper');
        $this->assertCount(1, $tags);

        $tag = $tags[0];
        $this->assertEquals('seiffert.helper.controller', $tag['broker']);
    }

    public function testExtensionProvidesFormHelper()
    {
        $containerBuilder = new ContainerBuilder();

        $this->extension->load(array(), $containerBuilder);

        $this->assertTrue($containerBuilder->hasDefinition('seiffert.helper.controller.form'));
        $definition = $containerBuilder->getDefinition('seiffert.helper.controller.form');

        $this->assertEquals(
            'Seiffert\ControllerHelperBundle\Helper\FormHelper',
            $containerBuilder->getParameter(str_replace('%', '', $definition->getClass()))
        );
        $this->assertCount(1, $definition->getArguments());

        $routerReference = new Reference('form.factory', ContainerInterface::IGNORE_ON_INVALID_REFERENCE);
        $this->assertEquals($routerReference, $definition->getArgument(0));

        $tags = $definition->getTag('seiffert.helper');
        $this->assertCount(1, $tags);

        $tag = $tags[0];
        $this->assertEquals('seiffert.helper.controller', $tag['broker']);
    }
}
