<?php
namespace TijmenWierenga\Bogus\Example;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
            "friends" => []
        ];
    }

    protected function create(array $attributes): object
    {
        $user = new User($attributes["name"]);
        $user->addFriends(...$attributes["friends"]);

        return $user;
    }
}

final class User
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var User[]|Collection
     */
    private $friends;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->friends = new ArrayCollection();
    }

    public function addFriends(User ...$users): void
    {
        foreach ($users as $user) {
            if (! $this->friends->contains($user)) {
                $this->friends->add($user);
            }
        }
    }

    /**
     * @return Collection|User[]
     */
    public function getFriends()
    {
        return $this->friends;
    }
}

$fixtures = new \TijmenWierenga\Bogus\Fixtures(new UserFactory());
$user = $fixtures->create(User::class, [
    "friends" => $fixtures->create(User::class, [], 3)
])->first(); // Creates a single user with 3 friends

var_dump($user);