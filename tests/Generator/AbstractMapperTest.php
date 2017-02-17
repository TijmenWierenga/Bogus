<?php
namespace TijmenWierenga\Bogus\Tests\Generator;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use TijmenWierenga\Bogus\Generator\MappingFile\AbstractMapper;
use TijmenWierenga\Bogus\Generator\MappingFile\Mappable;
use TijmenWierenga\Bogus\Tests\User;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class AbstractMapperTest extends TestCase
{
    /**
     * @var AbstractMapper
     */
    private $mapper;

    public function setUp()
    {
        $this->mapper = new class extends AbstractMapper implements Mappable {
            public static function attributes(): array
            {
                return [
                    'name' => (Factory::create())->firstName
                ];
            }

            public static function create(array $attributes)
            {
                return new User($attributes['name']);
            }
        };
    }

    /**
     * @test
     */
    public function it_generates_an_entity_based_on_provided_attributes()
    {
        /** @var User $result */
        $result = $this->mapper::build([
            'name' => 'Harry'
        ]);

        $this->assertEquals('Harry', $result->getName());
    }

    /**
     * @test
     */
    public function it_generates_an_entity_based_on_random_attributes()
    {
        /** @var User $resultOne */
        $resultOne = $this->mapper::build([]);
        /** @var User $resultTwo */
        $resultTwo = $this->mapper::build([]);

        $this->assertNotEquals($resultOne->getName(), $resultTwo->getName());
    }
}
