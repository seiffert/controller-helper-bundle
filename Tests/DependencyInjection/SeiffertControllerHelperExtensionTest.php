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

    /**
     * @var ContainerBuilder
     */
    private $container;

    public function setUp()
    {
        $this->extension = new SeiffertControllerHelperExtension();
        $this->container = new ContainerBuilder();

        $this->extension->load(array(), $this->container);
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
        $id = 'seiffert.helper.controller.router';

        $this->assertServiceHasClass($id, 'Seiffert\ControllerHelperBundle\Helper\RouterHelper');
        $this->assertServiceHasOneArgument(
            $id,
            new Reference('router', ContainerInterface::IGNORE_ON_INVALID_REFERENCE)
        );
        $this->assertServiceIsHelperAtBroker($id, 'seiffert.helper.controller');
    }

    public function testExtensionProvidesTemplateHelper()
    {
        $id = 'seiffert.helper.controller.template';

        $this->assertServiceHasClass($id, 'Seiffert\ControllerHelperBundle\Helper\TemplateHelper');
        $this->assertServiceHasOneArgument(
            $id,
            new Reference('templating', ContainerInterface::IGNORE_ON_INVALID_REFERENCE)
        );
        $this->assertServiceIsHelperAtBroker($id, 'seiffert.helper.controller');
    }

    public function testExtensionProvidesFlashMessageHelper()
    {
        $id = 'seiffert.helper.controller.flash_message';

        $this->assertServiceHasClass($id, 'Seiffert\ControllerHelperBundle\Helper\FlashMessageHelper');
        $this->assertServiceHasOneArgument(
            $id,
            new Reference('session', ContainerInterface::IGNORE_ON_INVALID_REFERENCE)
        );
        $this->assertServiceIsHelperAtBroker($id, 'seiffert.helper.controller');
    }

    public function testExtensionProvidesSecurityHelper()
    {
        $id = 'seiffert.helper.controller.security';

        $this->assertServiceHasClass($id, 'Seiffert\ControllerHelperBundle\Helper\SecurityHelper');
        $this->assertServiceHasOneArgument(
            $id,
            new Reference('security.context', ContainerInterface::IGNORE_ON_INVALID_REFERENCE)
        );
        $this->assertServiceIsHelperAtBroker($id, 'seiffert.helper.controller');
    }

    public function testExtensionProvidesFormHelper()
    {
        $id = 'seiffert.helper.controller.form';

        $this->assertServiceHasClass($id, 'Seiffert\ControllerHelperBundle\Helper\FormHelper');
        $this->assertServiceHasOneArgument(
            $id,
            new Reference('form.factory', ContainerInterface::IGNORE_ON_INVALID_REFERENCE)
        );
        $this->assertServiceIsHelperAtBroker($id, 'seiffert.helper.controller');
    }

    public function testExtensionProvidesValidatorHelper()
    {
        $id = 'seiffert.helper.controller.validator';

        $this->assertServiceHasClass($id, 'Seiffert\ControllerHelperBundle\Helper\ValidatorHelper');
        $this->assertServiceHasOneArgument(
            $id,
            new Reference('validator', ContainerInterface::IGNORE_ON_INVALID_REFERENCE)
        );
        $this->assertServiceIsHelperAtBroker($id, 'seiffert.helper.controller');
    }

    public function testExtensionProvidesDoctrineHelper()
    {
        $id = 'seiffert.helper.controller.doctrine';

        $this->assertServiceHasClass($id, 'Seiffert\ControllerHelperBundle\Helper\DoctrineHelper');
        $this->assertServiceHasOneArgument(
            $id,
            new Reference('doctrine.orm.entity_manager', ContainerInterface::IGNORE_ON_INVALID_REFERENCE)
        );
        $this->assertServiceIsHelperAtBroker($id, 'seiffert.helper.controller');
    }

    /**
     * @param string $serviceId
     * @param string $className
     */
    private function assertServiceHasClass($serviceId, $className)
    {
        $this->assertTrue($this->container->hasDefinition($serviceId));
        $definition = $this->container->getDefinition($serviceId);

        $this->assertEquals($className, $this->container->getParameter(str_replace('%', '', $definition->getClass())));
    }

    /**
     * @param string $serviceId
     * @param mixed $argument
     */
    private function assertServiceHasOneArgument($serviceId, $argument)
    {
        $definition = $this->container->getDefinition($serviceId);

        $this->assertCount(
            1,
            $definition->getArguments(),
            sprintf('Number of arguments of service %s does not equal 1', $serviceId)
        );
        $this->assertEquals($argument, $definition->getArgument(0), 'Argument 0 does not match expected value');
    }

    /**
     * @param string $serviceId
     * @param string $broker
     */
    private function assertServiceIsHelperAtBroker($serviceId, $broker)
    {
        $this->assertServiceHasTag(
            $serviceId,
            'seiffert.helper',
            array('broker' => $broker)
        );
    }

    /**
     * @param int $serviceId
     * @param string $tagName
     * @param array $tagAttributes
     */
    private function assertServiceHasTag($serviceId, $tagName, $tagAttributes)
    {
        $definition = $this->container->getDefinition($serviceId);

        $this->assertTrue(
            $definition->hasTag($tagName),
            sprintf('Service %s does not have tag %s', $serviceId, $tagName)
        );
        $tags = $definition->getTag($tagName);
        $tag = array_pop($tags);

        foreach ($tagAttributes as $key => $value) {
            $this->assertEquals(
                $tag[$key],
                $value,
                sprintf(
                    'Tag attribute %s of tag %s of service %s does not have expected value %s',
                    $key,
                    $tagName,
                    $serviceId,
                    $value
                )
            );
        }
    }
}
