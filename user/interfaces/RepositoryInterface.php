<?php


/**
 * Common interfaces for repositories
 * 
 * This interface will abstract the basic functionality of our persistence layer.
 * We don't particularly care what falls behind this, all of our front en API code
 * And how we interact with data will interface through this API.
 */
interface RepositoryInterface
{
    /**
     * Create a new entity
     */
    public function create();


    /**
     *  Find a an entity by its id
     * 
     * @param int $id The id for the entity to find
     */
    public function find($id);


    /**
     * Find all entities
     * 
     * @return array An array of all entities in the data store
     */
    public function findAll();


    /**
     * Persist an entity in the data store
     * 
     * @return void
     */
    public function persist(AbstractEntity $entity);
}