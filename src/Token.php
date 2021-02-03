<?php

namespace ChinLeung\Converge;

use ChinLeung\Converge\Contracts\Chargeable;

class Token implements Chargeable
{
    /**
     * The value of the generated token.
     *
     * @var string
     */
    protected $value;

    /**
     * Create a new token instance.
     *
     * @param  string  $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Retrieve the value of the token.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Retrieve the information of the card for a payload.
     *
     * @return array
     */
    public function toPayload(): array
    {
        return [
            'ssl_token' => $this->value,
        ];
    }
}
