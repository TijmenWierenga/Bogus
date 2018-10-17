<?php
namespace TijmenWierenga\Bogus\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TijmenWierenga\Bogus\Factory\Factory;
use TijmenWierenga\Bogus\Factory\FactoryNotFoundException;
use TijmenWierenga\Bogus\Fixtures;

class FixturesTest extends TestCase
{
    /**
     * @var Factory|MockObject
     */
    private $factory;
    /**
     * @var Fixtures
     */
    private $fixtures;

    public function setUp()
    {
        $this->factory = $this->getMockBuilder(Factory::class)->getMock();
        $this->fixtures = new Fixtures($this->factory);
    }
    public function testItCreatesAnEntityFromAFactory()
    {
        $this->factory->expects($this->once())
            ->method("creates")
            ->with("TijmenWierenga\\Entity\\Dummy")
            ->willReturn(true);

        $entity = new class {
            public $name = "Tijmen";
        };

        $this->factory->expects($this->exactly(3))
            ->method("build")
            ->with(["name" => "Tijmen"])
            ->willReturn($entity);

        $result = $this->fixtures->create("TijmenWierenga\\Entity\\Dummy", ["name" => "Tijmen"], 3);

        $this->assertCount(3, $result);
        $this->assertEquals($entity, $result[0]);
        $this->assertEquals($entity, $result[1]);
        $this->assertEquals($entity, $result[2]);
    }

    public function testItThrowsAFactoryNotFoundExceptionIfNoFactoryExistsForEntity()
    {
        $this->expectException(FactoryNotFoundException::class);
        $this->expectExceptionMessage("No factory was found for TijmenWierenga\\Entity\\Dummy");

        $this->factory->expects($this->once())
            ->method("creates")
            ->with("TijmenWierenga\\Entity\\Dummy")
            ->willReturn(false);

        $this->fixtures->create("TijmenWierenga\\Entity\\Dummy", [], 1);
    }
}
