<?php
namespace TijmenWierenga\Bogus\Tests\Generator;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use TijmenWierenga\Bogus\Collection\Collection;
use TijmenWierenga\Bogus\Config\Config;
use TijmenWierenga\Bogus\Exception\InvalidArgumentException;
use TijmenWierenga\Bogus\Generator\MappingFile\Mappable;
use TijmenWierenga\Bogus\Generator\MappingFile\MappingFileFactory;

class MappingFileFactoryTest extends TestCase
{
    /**
     * @var MappingFileFactory
     */
    private $factory;
    /**
     * @var Config|PHPUnit_Framework_MockObject_MockObject
     */
    private $config;

    public function setUp()
    {
        $this->config = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->factory = new MappingFileFactory($this->config);
    }

    /**
    * @test
    */
    public function it_calls_the_build_method_on_the_mapping_file()
    {
        $this->config->expects($this->once())
            ->method('get')
            ->willReturn(UserMapping::class);

        $result = $this->factory->build(User::class, [], 1);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertContainsOnlyInstancesOf(User::class, $result);
    }

    /**
     * @test
     */
    public function it_creates_multiple_fixtures()
    {
        $this->config->expects($this->once())
            ->method('get')
            ->willReturn(UserMapping::class);

        $result = $this->factory->build(User::class, [], 3);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertContainsOnlyInstancesOf(User::class, $result);
        $this->assertCount(3, $result);
    }
    
    /**
    * @test
    */
    public function it_throws_an_exception_when_mapping_is_unregistered()
    {
        $this->config->expects($this->once())
            ->method('get')
            ->willThrowException(new InvalidArgumentException());

    	$this->expectException(InvalidArgumentException::class);

        $this->factory->build(UnregisteredClass::class, [], 1);
    }
}

class User {}
class UnregisteredClass {}
class UserMapping implements Mappable {
    public static function build(iterable $attributes)
    {
        return new User;
    }
}