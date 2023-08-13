<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;
use function DI\string;

class CreateMessagesAction extends MessageAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $form = $this->getFormData();

        $message = $this->messageRepository->createMessage(
            (int) $form['conversation_id'],
            (int) $form['owner_id'],
            $form['text'],
            $form['sent_at']
        );

        $this->logger->info("Messages list was viewed.");

        return $this->respondWithData($message);
    }
}
