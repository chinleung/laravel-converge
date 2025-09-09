<?php

namespace ChinLeung\Converge;

use ChinLeung\Converge\Builders\RefundBuilder;
use ChinLeung\Converge\Concerns\Makeable;
use ChinLeung\Converge\Concerns\RequiresResponse;
use ChinLeung\Converge\Contracts\Transaction;

class Refund implements Transaction
{
    use Makeable, RequiresResponse;

    /**
     * Retrieve a new instance of the builder.
     *
     * @return \ChinLeung\Converge\Builders\RefundBuilder
     */
    public static function builder(): RefundBuilder
    {
        return RefundBuilder::make();
    }

    /**
     * Create a refund.
     *
     * @param  string  $transaction
     * @param  int|null  $amount
     * @param  array  $options
     * @return self
     */
    public static function create(string $transaction, ?int $amount = null, array $options = []): self
    {
        $builder = static::builder()
            ->transaction($transaction)
            ->withOptions($options);

        if ($amount) {
            $builder->amount($amount);
        }

        return $builder->create();
    }

    /**
     * Retrieve the transaction id of the charge.
     *
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->response->get('ssl_txn_id');
    }
}
