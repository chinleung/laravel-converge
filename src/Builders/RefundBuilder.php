<?php

namespace ChinLeung\Converge\Builders;

use ChinLeung\Converge\Client;
use ChinLeung\Converge\Exceptions\CardException;
use ChinLeung\Converge\Refund;

class RefundBuilder extends Builder
{
    /**
     * The amount of the transaction as minor units to refund.
     *
     * @var array
     */
    protected $amount;

    /**
     * The id of the transaction to refund.
     *
     * @var string
     */
    protected $transaction;

    /**
     * Set the amount of the transaction as minor units to refund.
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
     * Process the charge.
     *
     * @link  https://developer.elavon.com/na/docs/converge/1.0.0/integration-guide/transaction_types/credit_card/return
     *
     * @return \ChinLeung\Converge\Refund
     */
    public function create(): Refund
    {
        $response = resolve(Client::class)->send('ccreturn', array_filter([
            'ssl_txn_id' => $this->transaction,
            'ssl_amount' => $this->amount / 100,
        ]));

        if ($response->get('ssl_result') === '1') {
            throw new CardException($response->get('ssl_result_message'));
        }

        return Refund::make($response);
    }

    /**
     * Set the id of the transction.
     *
     * @param  string  $transaction
     * @return self
     */
    public function transaction(int $transaction): self
    {
        $this->transaction = $transaction;

        return $this;
    }
}
