<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;

class InMemoryUserRepository implements UserRepository
{
    /**
     * @var User[]
     */
    private array $users;

    public function __construct()
    {
        $this->setUsers();
    }

    public function setUsers()
    {
        $json_object = file_get_contents('users.json');
        $json_array = json_decode($json_object, true);

        $this->users = [];

        array_map(function ($message) {
            $this->users = [...$this->users,
                new User(
                    $message['id'],
                    $message['name'],
                    $message['password'],
                    $message['last_seen_at'],
                )
            ];
        }, $json_array);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll($id): array
    {
        return array_filter($this->users, function ($user) use ($id) {
            return $id != $user->getId();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(int $id): User
    {
        $user = $this->searchForId($this->users, $id);

        return $this->users[$user];
    }

    public function createUser(
        string $name,
        string $password,
        string $last_seen_at
    ): User {
        $existed_user = array_filter($this->users, function ($user) use ($name) {
            return $name == $user->getName();
        });

        if (count($existed_user) == 0) {
            $newUser = new User(
                count($this->users) + 1,
                $name,
                $password,
                $last_seen_at,
            );
            $user_file = file_get_contents('users.json');
            $temp_array = json_decode($user_file);
            $temp_array = [...$temp_array, $newUser];
            $jsonData = json_encode($temp_array);
            file_put_contents('users.json', $jsonData);

            $this->setUsers();

            return $newUser;
        }

        $array_values = array_values($existed_user);

        return array_shift($array_values);
    }

    public function searchForId($array, $id)
    {
        foreach ($array as $key => $val) {
            if ($val->getId() === $id) {
                return $key;
            }
        }
        return null;
    }
}
