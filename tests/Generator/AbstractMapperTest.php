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
     * @test
     */
    public function it_generates_an_entity_based_on_provided_attributes()
    {
        $mapper = new class extends AbstractMapper implements Mappable {
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

        /** @var User $result */
        $result = $mapper::build([
            'name' => 'Harry'
        ]);

        $this->assertEquals('Harry', $result->getName());
    }
}
