<?php

declare(strict_types=1);

namespace App\Domain\Conversation;

use JsonSerializable;

class Conversation implements JsonSerializable
{
    private ?int $id;

    private ?string $name;

    private bool $is_group;

    private array $members;

    private string $last_message;

    private string $last_message_date;

    public function __construct(
        ?int $id,
        string $name,
        bool $is_group,
        array $members,
        string $last_message,
        string $last_message_date
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->is_group = $is_group;
        $this->members = $members;
        $this->last_message = $last_message;
        $this->last_message_date = $last_message_date;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_group' => $this->is_group,
            'members' => $this->members,
            'last_message' => $this->last_message,
            'last_message_date' => $this->last_message_date,
        ];
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getMembers(): array
    {
        return $this->members;
    }
}
