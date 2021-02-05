<?php

namespace ChinLeung\Converge\Builders;

use ChinLeung\Converge\Charge;
use ChinLeung\Converge\Client;
use ChinLeung\Converge\Concerns\HasCustomer;
use ChinLeung\Converge\Contracts\Chargeable;
use ChinLeung\Converge\Exceptions\CardException;

class ChargeBuilder extends Builder
{
    use HasCustomer;

    /**
     * The chargeable for the transaction.
     *
     * @var \ChinLeung\Converge\Contracts\Chargeable
     */
    protected $chargeable;

    /**
     * The amount of the charge as minor units.
     *
     * @var array
     */
    protected $amount;

    /**
     * Set the amount of the charge as minor units.
     *
     * @param  int  $amount
     * @return self
     */
    public function amount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Set the chargeable of the transaction.
     *
     * @param  \ChinLeung\Converge\Contracts\Chargeable  $chargeable
     * @return self
     */
    public function chargeable(Chargeable $chargeable): self
    {
        $this->chargeable = $chargeable;

        return $this;
    }

    /**
     * Process the charge.
     *
     * @return \ChinLeung\Converge\Charge
     */
    public function create(): Charge
    {
        $payload = array_merge(
            $this->chargeable->toPayload(),
            $this->options,
            [
                'ssl_amount' => $this->amount / 100,
            ]
        );

        if ($this->customer) {
            $payload = array_merge($payload, $this->customer->toPayload());
        }

        $response = resolve(Client::class)->send('ccsale', $payload);

        if ($response->get('ssl_result') === '1') {
            throw new CardException($response->get('ssl_result_message'));
        }

        return Charge::make($response);
    }
}
