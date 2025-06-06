<?php

namespace App\UseCases;

class Entity
{
    public function __construct(array $values = [], ?callable $transformer = null)
    {
        foreach ($values as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $transformer ? $transformer($value) : $value;
            }
        }
    }
}