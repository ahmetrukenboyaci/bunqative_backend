<?php

declare(strict_types=1);

namespace App\Domain\Message;

interface MessageRepository
{
    /**
     * @param int $conversation_id
     * @return Message[]
     */
    public function findAll(int $conversation_id): array;

    /**
     * @param int $id
     * @return Message
     * @throws MessageNotFoundException
     */
    public function findMessageOfId(int $id): Message;

    /**
     * @param int $conversation_id
     * @param int $owner_id
     * @param string $text
     * @param string $sent_at
     * @return array
     */
    public function createMessage(
        int $conversation_id,
        int $owner_id,
        string $text,
        string $sent_at
    ): array;
}
