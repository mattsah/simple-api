<?php

/**
 * An action to select a specific user
 */
class SelectUser extends AbstractAction
{
    /**
     * Run the action
     * 
     * @var Users $user the Users repository
     * @return Response A PSR-7 response
     */
    public function __invoke(Users $users, $id)
    {
        $user = $users->find($id);

        if (!$user) {
            return $this->respond(404, NULL);
        }

        return $this->respond(200, json_encode($user), [
            'Content-Type' => 'application/json'
        ]);
    }
}