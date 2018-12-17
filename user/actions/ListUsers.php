<?php

/**
 * An action to list all users
 */
class ListUsers extends AbstractAction
{
    /**
     * Run the action
     * 
     * @var Users $user the Users repository
     * @return Response A PSR-7 response
     */
    public function __invoke(Users $users)
    {
        return $this->respond(200, json_encode($users->findAll()), [
            'Content-Type' => 'application/json'
        ]);
    }
}