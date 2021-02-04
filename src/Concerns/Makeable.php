<?php

namespace ChinLeung\Converge\Concerns;

trait Makeable
{
    /**
     * Create a new instance of the class.
     *
     * @return self
     */
    public static function make(...$args)
    {
        return new static(...$args);
    }
}
