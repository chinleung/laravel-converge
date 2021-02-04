<?php

namespace ChinLeung\Converge;

use ChinLeung\Converge\Concerns\Makeable;
use ChinLeung\Converge\Contracts\Chargeable;
use Illuminate\Support\Carbon;

class Card implements Chargeable
{
    use Makeable;

    /**
     * The card number.
     *
     * @var string
     */
    protected $number;

    /**
     * The expiration date of the card.
     *
     * @var string
     */
    protected $expiry;

    /**
     * The security code of the card.
     *
     * @var string
     */
    protected $cvc;

    /**
     * Create a new instance of the card.
     *
     * @param  string  $number
     * @param  string  $expiry
     * @param  string  $cvc
     */
    public function __construct(string $number, string $expiry, string $cvc)
    {
        $this->number = $number;
        $this->expiry = $expiry;
        $this->cvc = $cvc;
    }

    /**
     * Create a test American Express card.
     *
     * @return self
     */
    public static function americanExpress(): self
    {
        return static::fake('370000000000002');
    }

    /**
     * Generate a card instance with a fake number.
     *
     * @param  string  $number
     * @return self
     */
    public static function fake(string $number): self
    {
        return new static(
            $number,
            Carbon::now()->addYear()->format('my'),
            mt_rand(100, 999)
        );
    }

    /**
     * Retrieve the cvc of the card.
     *
     * @return string
     */
    public function getCvc(): string
    {
        return $this->cvc;
    }

    /**
     * Retrieve the expiration of the card.
     *
     * @return string
     */
    public function getExpiry(): string
    {
        return $this->expiry;
    }

    /**
     * Retrieve the number of the card.
     *
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * Create a test MasterCard card.
     *
     * @return self
     */
    public static function masterCard(): self
    {
        return static::fake('5121212121212124');
    }

    /**
     * Retrieve the information of the card for a payload.
     *
     * @return array
     */
    public function toPayload(): array
    {
        return [
            'ssl_card_number' => $this->number,
            'ssl_exp_date' => $this->expiry,
            'ssl_cvv2cvc2' => $this->cvc,
        ];
    }

    /**
     * Create a test Visa card.
     *
     * @return self
     */
    public static function visa(): self
    {
        return static::fake('4000000000000002');
    }

    /**
     * Create a test Visa Corporate card.
     *
     * @return self
     */
    public static function visaCorporate(): self
    {
        return static::fake('4159288888888882');
    }
}
