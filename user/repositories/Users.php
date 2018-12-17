<?php

/**
 * A basic user repository
 */
class Users extends AbstractArrayRepository
{
    /**
     * Create a new entity
     * 
     * @return User The newly created user entity
     */
    public function create()
    {
        return new User();
    }
}