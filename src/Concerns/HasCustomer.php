<?php

namespace ChinLeung\Converge\Concerns;

use ChinLeung\Converge\Customer;

trait HasCustomer
{
    /**
     * The customer of the card.
     *
     * @var \ChinLeung\Converge\Customer
     */
    protected $customer;

    /**
     * Set the customer of the token.
     *
     * @param  \ChinLeung\Converge\Customer  $customer
     * @return self
     */
    public function customer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
