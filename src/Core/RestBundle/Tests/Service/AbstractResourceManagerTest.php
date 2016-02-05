<?php

namespace Core\RestBundle\Tests\Service;

use Core\RestBundle\CoreRestEvents;
use Core\RestBundle\Service\AbstractResourceManager;
use Core\RestBundle\Tests\Stub_ConstraintViolationList;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Traversable;

/**
 * @author Gabriel Theron <gabriel@class-web.fr>
 * @copyright Class-Web
 */
class AbstractResourceManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractResourceManager
     */
    private $rm;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $om;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $dispatcher;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $validator;

    public function setUp()
    {
        $this->om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->validator = $this->getMock('Symfony\Component\Validator\Validator\ValidatorInterface');

        $this->rm = $this->getMockForAbstractClass('Core\RestBundle\Service\AbstractResourceManager');
        $this->rm->expects($this->any())
            ->method('getManager')
            ->will($this->returnValue($this->om));
        $this->rm->expects($this->any())
            ->method('getEventDispatcher')
            ->will($this->returnValue($this->dispatcher));
        $this->rm->expects($this->any())
            ->method('getValidator')
            ->will($this->returnValue($this->validator));
    }

    /**
     * Teste le succès de la validation
     */
    public function test_validate_success()
    {
        $resource = $this->getMock('Core\RestBundle\Model\ResourceInterface');

        $this->validator->expects($this->once())
            ->method('validate')
            ->with($this->equalTo($resource))
            ->willReturn(array());

        $this->dispatcher->expects($this->exactly(2))
            ->method('dispatch');

        $result = $this->rm->validate($resource);

        $this->assertEquals($resource, $result);
    }

    /**
     * @expectedException Core\RestBundle\Exception\ValidationException
     */
    public function test_validate_failure()
    {
        $resource = $this->getMock('Core\RestBundle\Model\ResourceInterface');

        $violationList = new Stub_ConstraintViolationList(2);

        $this->validator->expects($this->once())
            ->method('validate')
            ->with($this->equalTo($resource))
            ->willReturn($violationList);

        $this->dispatcher->expects($this->once())
            ->method('dispatch');

        $result = $this->rm->validate($resource);

        $this->assertEquals($resource, $result);
    }
}