<?php
namespace TijmenWierenga\Bogus\Tests;


use PHPUnit\Framework\TestCase;
use TijmenWierenga\Bogus\Collection\BogusCollection;
use TijmenWierenga\Bogus\Collection\Collection;
use TijmenWierenga\Bogus\Fixtures;
use TijmenWierenga\Bogus\Generator\Factory;
use TijmenWierenga\Bogus\Storage\LogStorageAdapter;

class FixturesTest extends TestCase
{
    /**
     * @var Fixtures
     */
    private $fixtures;

    public function setUp()
    {
        $this->fixtures = new Fixtures(
            new LogStorageAdapter(),
            new TestFactory()
        );
    }

    /**
     * @test
     */
    public function it_creates_a_dummy_fixture()
    {
        $result = $this->fixtures->create(DummyModel::class);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertContainsOnlyInstancesOf(DummyModel::class, $result);
    }
}

class DummyModel {}

class TestFactory implements Factory
{
    public function build(string $entityClassName, iterable $attributes, int $amount): Collection
    {
        return new BogusCollection([new $entityClassName]);
    }
}