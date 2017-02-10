<?php
namespace TijmenWierenga\Bogus\Tests\Storage\RepositoryStorageTest;


use Interop\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use TijmenWierenga\Bogus\Collection\BogusCollection;
use TijmenWierenga\Bogus\Config\Config;
use TijmenWierenga\Bogus\Storage\Repository\RepositoryStorage;
use TijmenWierenga\Bogus\Tests\User;
use TijmenWierenga\Bogus\Tests\UserRepository;

class RepositoryStorageTest extends TestCase
{
    /**
     * @var ContainerInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $container;

    /**
     * @var Config|PHPUnit_Framework_MockObject_MockObject
     */
    private $config;

    /**
     * @var RepositoryStorage
     */
    private $repositoryStorage;

    public function setUp()
    {
        $this->container = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->config = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->repositoryStorage = new RepositoryStorage($this->container, $this->config);
    }

    /**
    * @test
    */
    public function it_saves_a_collection_of_entities()
    {
        $userRepository = $this->getMockBuilder(UserRepository::class)->getMock();
        $collection = new BogusCollection([new User('Tijmen')]);

        $this->config->expects($this->once())
            ->method('get')
            ->with(User::class . ".repository")
            ->willReturn([
                'class' => UserRepository::class,
                'method' => 'save'
            ]);
        $this->container->expects($this->once())
            ->method('get')
            ->with(UserRepository::class)
            ->willReturn($userRepository);
        $userRepository->expects($this->once())
            ->method('save')
            ->with($collection);

        $this->repositoryStorage->save($collection);
    }
}