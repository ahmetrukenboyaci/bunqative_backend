<?php

declare(strict_types=1);

use App\Application\Actions\User\CreateUsersAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Actions\Message\ListMessagesAction;
use App\Application\Actions\Message\ViewMessageAction;
use App\Application\Actions\Message\CreateMessagesAction;
use App\Application\Actions\Conversation\ListConversationsAction;
use App\Application\Actions\Conversation\CreateConversationsAction;
use App\Application\Actions\Conversation\ViewConversationAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Bunqative app!');
        return $response;
    });

    $app->group('/user', function (Group $group) {
        $group->get('/all/{id}', ListUsersAction::class);
        $group->post('', CreateUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
        $group->group('/{user_id}/conversation', function (Group $group) {
            $group->get('', ListConversationsAction::class);
            $group->post('', CreateConversationsAction::class);
            $group->get('/{id}', ViewConversationAction::class);
            $group->group('/{conversation_id}/message', function (Group $group) {
                $group->get('', ListMessagesAction::class);
                $group->post('', CreateMessagesAction::class);
                $group->get('/{id}', ViewMessageAction::class);
            });
        });
    });
};
