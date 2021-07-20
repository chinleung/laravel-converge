<?php

namespace ChinLeung\Converge\Builders;

use ChinLeung\Converge\Card;
use ChinLeung\Converge\Client;
use ChinLeung\Converge\Concerns\HasCustomer;
use ChinLeung\Converge\Exceptions\CardException;
use ChinLeung\Converge\Token;

class TokenBuilder extends Builder
{
    use HasCustomer;

    /**
     * The card that should be used for the token.
     *
     * @var \ChinLeung\Converge\Card
     */
    protected $card;

    /**
     * Set the card of the token.
     *
     * @param  \ChinLeung\Converge\Card  $card
     * @return self
     */
    public function card(Card $card): self
    {
        $this->card = $card;

        return $this;
    }

    /**
     * Create the token.
     *
     * @link  https://developer.elavon.com/na/docs/converge/1.0.0/integration-guide/transaction_types/card_manager/generate_token
     *
     * @return \ChinLeung\Converge\Token
     */
    public function create(): Token
    {
        $payload = array_merge($this->card->toPayload(), $this->options);

        if ($this->customer) {
            $payload = array_merge($payload, $this->customer->toPayload());
        }

        $response = resolve(Client::class)->send('ccgettoken', $payload);

        if ($response->get('ssl_result') === '1') {
            throw new CardException($response->get('ssl_result_message'));
        }

        return Token::make($response->get('ssl_token'));
    }

    /**
     * Save the token.
     *
     * @return \ChinLeung\Converge\Token
     */
    public function save(): Token
    {
        return $this->withOptions(array_merge([
            'ssl_add_token' => 'Y',
        ]))->create();
    }
}
