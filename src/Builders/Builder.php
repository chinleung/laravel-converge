<?php

namespace ChinLeung\Converge\Builders;

use ChinLeung\Converge\Concerns\Makeable;

abstract class Builder
{
    use Makeable;

    /**
     * The options of the builder.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Update the builder's options.
     *
     * @param  array  $options
     * @return self
     */
    public function withOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }
}
