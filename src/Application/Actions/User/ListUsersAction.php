<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class ListUsersAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $id = (int) $this->resolveArg('id');
        $users = $this->userRepository->findAll($id);

        $this->logger->info("Users list was viewed.");

        return $this->respondWithData($users);
    }
}
