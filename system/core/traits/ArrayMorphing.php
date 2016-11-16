<?php

namespace System\Traits;

/**
 * Class ArrayMorphing
 * Trait used for adding possibility to a class to transform stdObject into array
 *
 * @package System\Traits
 */
trait ArrayMorphing
{
    /**
     * That method gets object or something else and trying to transform it into array
     * It is working recursive
     *
     * @param object|mixed $object
     *
     * @return array|mixed
     */
    protected function morphToArray($object)
    {
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }

        return array_map([$this, 'morphToArray'], (array)$object);
    }
}