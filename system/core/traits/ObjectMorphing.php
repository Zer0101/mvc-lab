<?php

namespace System\Traits;

/**
 * Class ObjectMorphing
 * Trait used for adding possibility to a class to transform array into stdObject
 *
 * @package System\Traits
 */
trait ObjectMorphing
{
    /**
     * That method gets array or something else and trying to transform it into stdObject
     * It is working recursive
     *
     * @param array|mixed $array
     *
     * @return \stdClass|mixed
     */
    protected function morphToObject($array)
    {
        if (!is_array($array)) {
            return $array;
        }

        $object = new \stdClass();
        foreach ($array as $name => $value) {
            $name = strtolower(trim($name));
            if (!empty($name)) {
                $object->$name = $this->morphToObject($value);
            }
        }
        return $object;
    }
}