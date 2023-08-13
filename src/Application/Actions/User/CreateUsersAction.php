<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\User\UserAction;
use Psr\Http\Message\ResponseInterface as Response;

use function DI\string;

class CreateUsersAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $form = $this->getFormData();

        $user = $this->userRepository->createUser(
            $form['name'],
            $form['password'],
            date("c")
        );

        return $this->respondWithData($user);
    }
}
