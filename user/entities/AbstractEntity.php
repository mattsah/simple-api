<?php


/**
 * An abstract entity which contains the most basic properties / methods that all entities share
 */
abstract class AbstractEntity implements JsonSerializable
{
    /**
     * The array of data values for this entity
     * 
     * @access protected
     * @var int
     */
    public $id = NULL;


    /**
     * Hydrate the entity with some data
     * 
     * @access public
     * @access array $data The data with which to hydrate the object
     * @return $this The object for method chaining
     */
    public function hydrate(array $data)
    {
        foreach ($data as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }


    /**
     * Convert the entity to an array
     * 
     * @return array The entity properties as an array
     */
    public function toArray()
    {
        return (array) get_object_vars($this);
    }


    /**
     * Convert the entity to data available in JSON representation
     * 
     * @return array The data available in JSON representation as an array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}