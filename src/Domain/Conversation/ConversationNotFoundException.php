<?php

declare(strict_types=1);

namespace App\Domain\Conversation;

use App\Domain\DomainException\DomainRecordNotFoundException;

class ConversationNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The user you requested does not exist.';
}
