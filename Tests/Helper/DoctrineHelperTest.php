<?php

namespace Seiffert\ControllerHelperBundle\Tests\Helper;

use Doctrine\Common\Persistence\ObjectManager;
use Seiffert\ControllerHelperBundle\Helper\DoctrineHelper;

/**
 * @covers Seiffert\ControllerHelperBundle\Helper\DoctrineHelper
 */
class DoctrineHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mockEntityManager;

    /**
     * @var DoctrineHelper
     */
    private $helper;

    public function setUp()
    {
        $this->helper = new DoctrineHelper($this->getMockEntityManager());
    }

    public function tearDown()
    {
        $this->mockEntityManager = null;
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf('Seiffert\HelperBundle\HelperInterface', $this->helper);
        $this->assertInstanceOf('Seiffert\ControllerHelperBundle\Helper\DoctrineHelper', $this->helper);
    }

    public function testHelperProvidesGetEntityManagerMethod()
    {
        $this->assertContains('getEntityManager', $this->helper->getHelperMethodNames());
    }

    public function testGetEntityManager()
    {
        $this->assertSame($this->getMockEntityManager(), $this->helper->getEntityManager());
    }

    public function testHelperProvidesPersistMethod()
    {
        $this->assertContains('persist', $this->helper->getHelperMethodNames());
    }

    public function testPersistCallsEntityManager()
    {
        $entity = 'test';

        $this->getMockEntityManager()
            ->expects($this->once())
            ->method('persist')
            ->with($entity);

        $this->helper->persist($entity);
    }

    public function testHelperProvidesFlushMethod()
    {
        $this->assertContains('flush', $this->helper->getHelperMethodNames());
    }

    public function testFlushCallsEntityManager()
    {
        $entity = 'test';

        $this->getMockEntityManager()
            ->expects($this->once())
            ->method('flush')
            ->with($entity);

        $this->helper->flush($entity);
    }

    /**
     * @return ObjectManager|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockEntityManager()
    {
        if (null === $this->mockEntityManager) {
            $this->mockEntityManager = $this->getMock(
                'Doctrine\Common\Persistence\ObjectManager',
                array(),
                array(),
                '',
                false
            );
        }

        return $this->mockEntityManager;
    }
}
