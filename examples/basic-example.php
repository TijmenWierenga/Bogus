<?php
namespace TijmenWierenga\Bogus\Example;

use TijmenWierenga\Bogus\Factory\AbstractFactory;
use TijmenWierenga\Bogus\Factory\Factory;

require_once __DIR__ . '/../vendor/autoload.php';

final class UserFactory extends AbstractFactory implements Factory
{
    public function creates(string $entityClassName): bool
    {
        return $entityClassName === User::class;
    }

    protected function attributes(): iterable
    {
        $factory = \Faker\Factory::create();

        return [
            "name" => $factory->firstName,
            "email" => $factory->email
        ];
    }

    protected function create(iterable $attributes): object
    {
        return new User($attributes["name"], $attributes["email"]);
    }
}

class User
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $email;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}

$fixtures = new \TijmenWierenga\Bogus\Fixtures(new UserFactory());
var_dump($fixtures->create(User::class, [], 100)); // Array of 3 users
