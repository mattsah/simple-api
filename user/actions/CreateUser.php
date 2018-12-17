<?php

/**
 * Action to create a user
 */
class CreateUser extends AbstractAction
{
    /**
     * Run the action
     * 
     * @var Users $user the Users repository
     * @return Response A PSR-7 response
     */
    public function __invoke(Users $users)
    {
        $user = $users->create();

        $user->hydrate($this->request->getParsedBody());
        $users->persist($user, TRUE);

        return $this->respond(201, json_encode($user), [
            'Content-Type' => 'application/json'
        ]);    
    }
}