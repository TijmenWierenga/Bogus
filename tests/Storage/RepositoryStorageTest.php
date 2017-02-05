<?php
namespace TijmenWierenga\Bogus\Tests\Storage\RepositoryStorageTest;


use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use TijmenWierenga\Bogus\Collection\BogusCollection;
use TijmenWierenga\Bogus\Config\Config;
use TijmenWierenga\Bogus\Container\Container;
use TijmenWierenga\Bogus\Storage\Repository\RepositoryStorage;

class RepositoryStorageTest extends TestCase
{
    /**
     * @var Container|PHPUnit_Framework_MockObject_MockObject
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
        $this->container = $this->getMockBuilder(Container::class)
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
        $collection = new BogusCollection([new User()]);

        $this->config->expects($this->once())
            ->method('get')
            ->with(User::class)
            ->willReturn([
                'repository' => UserRepository::class,
                'save' => 'save'
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

class User {};
class UserRepository {
    public function save(BogusCollection $collection)
    {

    }
}