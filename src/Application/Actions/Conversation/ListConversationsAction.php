<?php

declare(strict_types=1);

namespace App\Application\Actions\Conversation;

use Psr\Http\Message\ResponseInterface as Response;

class ListConversationsAction extends ConversationAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('user_id');

        $conversations = $this->conversationRepository->findAll($userId);

        $this->logger->info("Conversations list was viewed.");

        return $this->respondWithData($conversations);
    }
}
