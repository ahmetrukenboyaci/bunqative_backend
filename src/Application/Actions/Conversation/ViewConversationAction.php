<?php

declare(strict_types=1);

namespace App\Application\Actions\Conversation;

use Psr\Http\Message\ResponseInterface as Response;

class ViewConversationAction extends ConversationAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $conversationId = (int) $this->resolveArg('id');
        $conversation = $this->conversationRepository->findConversationOfId($conversationId);

        $this->logger->info("Conversation of id `{$conversationId}` was viewed.");

        return $this->respondWithData($conversation);
    }
}
