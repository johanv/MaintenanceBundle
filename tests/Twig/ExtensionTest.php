<?php
namespace BretRZaun\MaintenanceBundle\Tests;

use BretRZaun\MaintenanceBundle\MaintenanceService;
use BretRZaun\MaintenanceBundle\Twig\Extension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ExtensionTest extends TestCase
{

    public function testMaintenance(): void
    {
        $paramBag = new ParameterBag();
        $paramBag->add(['maintenance' => []]);

        $maintenanceService = $this->getMockBuilder(MaintenanceService::class)
            ->setConstructorArgs([$paramBag])
            ->setMethods(['isMaintenance'])
            ->getMock()
        ;
        $maintenanceService->expects($this->once())
            ->method('isMaintenance')
            ->willReturn(true);

        $requestStack = new RequestStack();
        $requestStack->push(new Request());
        $extension = new Extension($maintenanceService, $requestStack);
        $this->assertTrue($extension->maintenanceMode());
    }
}
