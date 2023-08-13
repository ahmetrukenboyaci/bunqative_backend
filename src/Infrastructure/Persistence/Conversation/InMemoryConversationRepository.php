<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Conversation;

use App\Domain\Conversation\Conversation;
use App\Domain\Conversation\ConversationNotFoundException;
use App\Domain\Conversation\ConversationRepository;

class InMemoryConversationRepository implements ConversationRepository
{
    /**
     * @var Conversation[]
     */
    private array $conversations;

    public function __construct()
    {
        $this->setConversations();
    }

    public function setConversations()
    {
        $json_object = file_get_contents('conversations.json');
        $json_array = json_decode($json_object, true);

        $this->conversations = [];

        array_map(function ($conversation) {
            $this->conversations = [...$this->conversations,
                new Conversation(
                    $conversation['id'],
                    $conversation['name'],
                    $conversation['is_group'],
                    $conversation['members'],
                    $conversation['last_message'],
                    $conversation['last_message_date']
                )
            ];
        }, $json_array);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(int $user_id): array
    {
        return array_filter($this->conversations, function ($conversation) use ($user_id) {
            return in_array($user_id, $conversation->getMembers());
        });
    }

    /**
     * {@inheritdoc}
     */
    public function findConversationOfId(int $id): Conversation
    {
        $conv = $this->searchForId($this->conversations, $id);

        return $this->conversations[$conv];
    }

    /**
     * {@inheritdoc}
     */
    public function createConversation(
        string $name,
        bool $is_group,
        array $members,
        string $last_message,
        string $last_message_date
    ): Conversation {

        $newConversation = new Conversation(
            count($this->conversations) + 1,
            $name,
            $is_group,
            $members,
            $last_message,
            $last_message_date
        );
        $conversation_file = file_get_contents('conversations.json');
        $temp_array = json_decode($conversation_file);
        $temp_array = [...$temp_array, $newConversation];
        $jsonData = json_encode($temp_array);
        file_put_contents('conversations.json', $jsonData);

        $this->setConversations();

        return $newConversation;
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
