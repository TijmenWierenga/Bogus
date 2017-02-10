<?php
namespace TijmenWierenga\Bogus\Tests\Container;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TijmenWierenga\Bogus\Collection\BogusCollection;
use TijmenWierenga\Bogus\Config\ConfigFile;
use TijmenWierenga\Bogus\Config\YamlConfig;
use TijmenWierenga\Bogus\Fixtures;
use TijmenWierenga\Bogus\Generator\Factory;
use TijmenWierenga\Bogus\Storage\Repository\Adapter\SymfonyContainerAwareRepositoryAdapter;
use TijmenWierenga\Bogus\Tests\User;
use TijmenWierenga\Bogus\Tests\UserRepository;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class SymfonyContainerAdapterTest extends TestCase
{
    /**
     * @test
     */
    public function it_transforms_a_symfony_container_into_a_interop_container()
    {
        $symfonyContainer = new DummySymfonyContainer();
        $configFile = new ConfigFile(__DIR__ . '/ContainerConfig.yml');
        $config = new YamlConfig($configFile);
        $symfonyAdapter = new SymfonyContainerAwareRepositoryAdapter($symfonyContainer, $config);

        /** @var Factory|PHPUnit_Framework_MockObject_MockObject $factory */
        $factory = $this->getMockBuilder(Factory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $factory->expects($this->once())
            ->method('build')
            ->willReturn(new BogusCollection([new User('Tijmen')]));

        $fixtures = new Fixtures($symfonyAdapter, $factory);

        $userCollection = $fixtures->create(User::class);

        $this->assertContainsOnlyInstancesOf(User::class, $userCollection);
    }
}

class DummySymfonyContainer implements ContainerInterface
{
    public function set($id, $service) {}
    public function get($id, $invalidBehavior = self::EXCEPTION_ON_INVALID_REFERENCE) {
        return new UserRepository();
    }
    public function has($id) {}
    public function initialized($id) {}
    public function getParameter($name) {}
    public function hasParameter($name) {}
    public function setParameter($name, $value) {}
}
