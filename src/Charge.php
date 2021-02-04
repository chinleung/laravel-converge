<?php

namespace ChinLeung\Converge;

use ChinLeung\Converge\Builders\ChargeBuilder;
use ChinLeung\Converge\Concerns\Makeable;
use ChinLeung\Converge\Concerns\RequiresResponse;
use ChinLeung\Converge\Contracts\Chargeable;
use ChinLeung\Converge\Contracts\Transaction;

class Charge implements Transaction
{
    use Makeable, RequiresResponse;

    /**
     * Retrieve a new instance of the builder.
     *
     * @return \ChinLeung\Converge\Builders\ChargeBuilder
     */
    public static function builder(): ChargeBuilder
    {
        return ChargeBuilder::make();
    }

    /**
     * Create a charge.
     *
     * @param  \ChinLeung\Converge\Contracts\Chargeable  $chargeable
     * @param  int  $amount
     * @param  array  $options
     * @return self
     */
    public static function create(Chargeable $chargeable, int $amount, array $options = []): self
    {
        return static::builder()
            ->chargeable($chargeable)
            ->amount($amount)
            ->withOptions($options)
            ->create();
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
