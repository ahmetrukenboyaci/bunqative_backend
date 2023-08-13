<?php

declare(strict_types=1);

namespace App\Domain\Message;

use JsonSerializable;

class Message implements JsonSerializable
{
    private ?int $id;

    private int $conversation_id;

    private int $owner_id;

    private string $text;

    private string $sent_at;

    public function __construct(
        ?int $id,
        int $conversation_id,
        int $owner_id,
        string $text,
        string $sent_at
    ) {
        $this->id = $id;
        $this->conversation_id = $conversation_id;
        $this->owner_id = $owner_id;
        $this->text = $text;
        $this->sent_at = $sent_at;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'conversation_id' => $this->conversation_id,
            'owner_id' => $this->owner_id,
            'text' => $this->text,
            'sent_at' => $this->sent_at,
        ];
    }

    /**
     * @return int
     */
    public function getConversationId(): int
    {
        return $this->conversation_id;
    }
}
