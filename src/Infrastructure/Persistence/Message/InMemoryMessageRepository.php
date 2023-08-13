<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Message;

use App\Domain\Message\Message;
use App\Domain\Message\MessageNotFoundException;
use App\Domain\Message\MessageRepository;

class InMemoryMessageRepository implements MessageRepository
{
    /**
     * @var Message[]
     */
    private array $messages;

    public function __construct()
    {
        $this->setMessages();
    }

    public function setMessages()
    {
        $json_object = file_get_contents('messages.json');
        $json_array = json_decode($json_object, true);

        $this->messages = [];

        array_map(function ($message) {
            $this->messages = [...$this->messages,
                new Message(
                    $message['id'],
                    $message['conversation_id'],
                    $message['owner_id'],
                    $message['text'],
                    $message['sent_at']
                )
            ];
        }, $json_array);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(int $conversation_id): array
    {
        return  array_filter($this->messages, function ($message) use ($conversation_id) {
            return $conversation_id == $message->getConversationId();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function findMessageOfId(int $id): Message
    {
        if (!isset($this->messages[$id])) {
            throw new MessageNotFoundException();
        }

        return $this->messages[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function createMessage(
        int $conversation_id,
        int $owner_id,
        string $text,
        string $sent_at
    ): array {
        $newMessage = new Message(count($this->messages) + 1, $conversation_id, $owner_id, $text, $sent_at);
        $message_file = file_get_contents('messages.json');
        $temp_array = json_decode($message_file);
        $temp_array = [...$temp_array, $newMessage];
        $jsonData = json_encode($temp_array);
        file_put_contents('messages.json', $jsonData);

        $this->setMessages();

        return array_filter($this->messages, function ($message) use ($conversation_id) {
            return $conversation_id == $message->getConversationId();
        });
    }
}
