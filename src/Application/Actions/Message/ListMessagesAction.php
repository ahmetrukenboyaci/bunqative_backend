<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;

class ListMessagesAction extends MessageAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $conversationId = (int) $this->resolveArg('conversation_id');

        $messages = $this->messageRepository->findAll($conversationId);

        $this->logger->info("Messages list was viewed.");

        return $this->respondWithData($messages);
    }
}
