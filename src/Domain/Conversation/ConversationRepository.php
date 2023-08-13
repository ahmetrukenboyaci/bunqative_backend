<?php

declare(strict_types=1);

namespace App\Domain\Conversation;

interface ConversationRepository
{
    /**
     * @param int $user_id
     * @return Conversation[]
     */
    public function findAll(int $user_id): array;

    /**
     * @param int $id
     * @return Conversation
     * @throws ConversationNotFoundException
     */
    public function findConversationOfId(int $id): Conversation;

    /**
     * @param string $name
     * @param bool $is_group
     * @param array $members
     * @param string $last_message
     * @param string $last_message_date
     * @return Conversation
     */
    public function createConversation(
        string $name,
        bool $is_group,
        array $members,
        string $last_message,
        string $last_message_date
    ): Conversation;
}
