<?php

namespace System\Config;

/**
 * Interface Config
 * Base contract for any configuration class
 * Useful for creating decorators.
 * Simple say classes with this contract can be used as decorators one for another
 *
 * @package System\Config
 */
interface Config
{
    /**
     * Magical method to get something from class
     * In context of the configuration class it is allows access only to container with configurations
     *
     * @param mixed $name
     *
     * @return mixed
     */
    public function __get($name);

    /**
     * Magical method to set something to class
     * In context of the configuration class it is allows access only to container with configurations
     *
     * @param string $name
     * @param mixed $value
     *
     * @return mixed
     */
    public function __set(string $name, $value);

    /**
     * Desperately (sometimes) needed method to get configuration like array
     * Because config class can have them in object format
     *
     * @param string|null $index
     *
     * @return array
     */
    public function toArray($index = null) :array;
}