<?php
namespace TijmenWierenga\Bogus\Example;

use TijmenWierenga\Bogus\Factory\AbstractFactory;

require_once __DIR__ . '/../vendor/autoload.php';

final class UserFactory extends AbstractFactory
{
    public function creates(string $entityClassName): bool
    {
        return $entityClassName === User::class;
    }

    protected function attributes(): array
    {
        $names = [
            "Tijmen",
            "Paul",
            "Hans",
            "Bart",
            "Robert",
            "Vivien",
            "Ellen",
            "Martha",
            "Amber",
            "Jennifer"
        ];

        return [
            "name" => $names[array_rand($names)],
        ];
    }

    protected function create(array $attributes): object
    {
        return new User($attributes["name"]);
    }
}

final class User
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}

$fixtures = new \TijmenWierenga\Bogus\Fixtures(new UserFactory());
var_dump($fixtures->create(User::class, [], 3)); // Collection of 3 users
