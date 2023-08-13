<?php

namespace App;

use App\Domain\Message\Message;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Chat implements MessageComponentInterface
{
    protected \SplObjectStorage $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

        echo "New connection!";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numReceived = count($this->clients) - 1;

        foreach ($this->clients as $client) {
                $message_file = file_get_contents('public/messages.json');
                $messages_json_array = json_decode($message_file, true);
                $message_std_obj = json_decode($msg);

                $messages_temp_array = array_map(function ($message) {
                    return new Message(
                        $message['id'],
                        $message['conversation_id'],
                        $message['owner_id'],
                        $message['text'],
                        $message['sent_at']
                    );
                }, $messages_json_array);

                $newMessage = new Message(
                    count($messages_temp_array) + 1,
                    $message_std_obj->conversation_id,
                    $message_std_obj->owner_id,
                    $message_std_obj->text,
                    $message_std_obj->sent_at
                );

                $messages_temp_array = [...$messages_temp_array, $newMessage];

                $json_data = json_encode($messages_temp_array);

                file_put_contents('public/messages.json', $json_data);

                $result = array_filter($messages_temp_array, function ($message) use ($message_std_obj) {
                    return $message_std_obj->conversation_id == $message->getConversationId();
                });

                $result_json = json_encode($result);

                $client->send($result_json);
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
