<?php

declare(strict_types=1);

namespace App\Domain\User;

use JsonSerializable;

class User implements JsonSerializable
{
    private ?int $id;

    private string $name;

    private string $password;

    private string $last_seen_at;

    public function __construct(?int $id, string $name, string $password, string $last_seen_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->last_seen_at = $last_seen_at;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'password' => $this->password,
            'last_seen_at' => $this->last_seen_at,
        ];
    }
}
