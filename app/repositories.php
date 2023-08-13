<?php

declare(strict_types=1);

use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Domain\Message\MessageRepository;
use App\Infrastructure\Persistence\Message\InMemoryMessageRepository;
use App\Domain\Conversation\ConversationRepository;
use App\Infrastructure\Persistence\Conversation\InMemoryConversationRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        MessageRepository::class => \DI\autowire(InMemoryMessageRepository::class),
        ConversationRepository::class => \DI\autowire(InMemoryConversationRepository::class),
    ]);
};
