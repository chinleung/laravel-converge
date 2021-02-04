<?php

namespace ChinLeung\Converge;

use ChinLeung\Converge\Builders\TokenBuilder;
use ChinLeung\Converge\Concerns\Makeable;
use ChinLeung\Converge\Contracts\Chargeable;

class Token implements Chargeable
{
    use Makeable;

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
     * Retrieve a new instance of the builder.
     *
     * @return \ChinLeung\Converge\Builders\TokenBuilder
     */
    public static function builder(): TokenBuilder
    {
        return TokenBuilder::make();
    }

    /**
     * Create a new token.
     *
     * @param  \ChinLeung\Converge\Card  $card
     * @return \ChinLeung\Converge\Token
     */
    public static function create(Card $card): Token
    {
        return static::builder()->card($card)->create();
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
     * Create a new token and save it in the token vault.
     *
     * @param  \ChinLeung\Converge\Card  $card
     * @return \ChinLeung\Converge\Token
     */
    public static function save(Card $card): Token
    {
        return static::builder()->card($card)->save();
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
