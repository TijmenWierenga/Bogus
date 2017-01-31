<?php
namespace TijmenWierenga\Bogus\Tests\Generator;


use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use TijmenWierenga\Bogus\Collection\BogusCollection;
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
        $this->config->expects($this->any())
            ->method('get')
            ->willReturn([
                User::class => UserMapping::class
            ]);
        $this->factory = new MappingFileFactory($this->config);
    }

    /**
    * @test
    */
    public function it_calls_the_build_method_on_the_mapping_file()
    {
        $result = $this->factory->build(User::class);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertContainsOnlyInstancesOf(User::class, $result);
    }

    /**
    * @test
    */
    public function it_throws_an_exception_when_mapping_is_unregistered()
    {
    	$this->expectException(InvalidArgumentException::class);

        $this->factory->build(UnregisteredClass::class);
    }
}

class User {}
class UnregisteredClass {}
class UserMapping implements Mappable {
    public function build(): Collection
    {
        return new BogusCollection([new User()]);
    }
}