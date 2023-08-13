<?php

declare(strict_types=1);

namespace App\Application\Actions\Conversation;

use App\Application\Actions\Conversation\ConversationAction;
use Psr\Http\Message\ResponseInterface as Response;

use function DI\string;

class CreateConversationsAction extends ConversationAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $form = $this->getFormData();

        $conversation = $this->conversationRepository->createConversation(
            $form['name'],
            (bool) $form['is_group'],
            (array) $form['members'],
            $form['last_message'],
            $form['last_message_date']
        );

        return $this->respondWithData($conversation);
    }
}
