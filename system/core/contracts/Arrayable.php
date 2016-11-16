<?php

namespace System\Contracts;

/**
 * Interface Arrayable
 * Contract for a class: return its content like an array
 *
 * @package System\Contracts
 */
interface Arrayable
{

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray() :array;
}