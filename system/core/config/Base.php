<?php

namespace System\Config;

use System\Contracts\Arrayable;
use System\Traits\{ArrayMorphing, ObjectMorphing};

class Base implements Config, Arrayable
{
    /**
     * Connecting ArrayMorphing trait
     */
    use ArrayMorphing;
    /**
     * Connecting ObjectMorphing trait
     */
    use ObjectMorphing;

    protected $container;

    /**
     * Base class constructor.
     *
     * @param array $config - array with configurations
     */
    public function __construct(array $config = [])
    {
        $this->container = (object)[];
        if (!empty($config)) {
            //Transform configs to object
            $this->container = $this->morphToObject($config);
        }
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        if (!empty($this->container->$name)) {
            return $this->container->$name;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function __set(string $name, $value)
    {
        //Transform values to object using trait
        $this->container->$name = $this->morphToObject($value);
    }

    /**
     * @inheritdoc
     */
    public function toArray($index = null) :array
    {
        if (!empty($this->container->$index)) {
            //Transform configs to array back
            //But only if we hav no index
            return $this->morphToArray($this->container->$index);
        }

        //Fetch and transform everithing
        return $this->morphToArray($this->container) ?? [];
    }
}