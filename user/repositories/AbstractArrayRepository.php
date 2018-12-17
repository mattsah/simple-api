<?php

/**
 * An abstract repository for accessing data in a JSON file
 */
abstract class AbstractArrayRepository implements RepositoryInterface
{
    /**
     * The array data we access
     * 
     * @var array
     */
    static protected $data = NULL;


    /**
     * The active objects we have loaded
     * 
     * @var array
     */
    static protected $objects = array();


    /**
     * The file where our data persists
     * 
     * @var string
     */
    protected $file = NULL;


    /**
     * Create a new repository using a JSON file to import the data
     * 
     * @param string $file The path to the file to load as the data store
     * @return void
     */
    public function __construct($file)
    {
        if (!file_exists($file)) {
            throw new \RuntimeException(sprintf(
                'Cannot access json data in file "%s"',
                $file)
            );
        }

        $this->file = $file;
    }


    /**
     * {@inheritDoc}
     */
    public function find($id)
    {
        $this->load();

        foreach (static::$data as $i => $row) {
            if ($row['id'] == $id) {
                return static::$objects[$i] = $this->create()->hydrate($row);
            }
        }

        return NULL;
    }


    /**
     * {@inheritDoc}
     */
    public function findAll()
    {
        $this->load();

        foreach (static::$data as $i => $row) {
            static::$objects[$i] = $this->create()->hydrate($row);
        }

        return static::$objects;
    }


    /**
     * Persist an entity
     * 
     * @param bool $write Whether or not we should immediately write to the persistance layer
     * @return void
     */
    public function persist(AbstractEntity $entity, $write = FALSE)
    {
        $this->load();

        $i = array_search($entity, static::$objects, TRUE);

        if ($i === FALSE) {
            static::$objects[] = $entity;
        }

        if ($write) {
            $this->write();
        }
    }


    /**
     * Load our entity data from our file if it's not already loaded
     * 
     * @var bool $force Whether or not to force reload the data from our JSON storage
     * @return void
     */
    private function load($force = FALSE)
    {
        if (static::$data === NULL || $force) {
            static::$data = json_decode(file_get_contents($this->file), TRUE) ?: [];
        }
    }


    /**
     * Write objects out to our data storage and reload all data
     * 
     * @return void
     */
    private function write()
    {
        $next_id = array_reduce(static::$data, function($next_id, $row) {
            if ($row['id'] > $next_id) {
                return $row['id'];               
            }
        });

        foreach (static::$objects as $i => $entity) {
            if (isset($entity->id)) {
                static::$data[$i] = $entity->toArray();

                continue;
            }

            $entity->id     = ++$next_id;
            static::$data[] = $entity->toArray();
        }

        file_put_contents($this->file, json_encode(static::$data));

        $this->load(TRUE);
    }
}