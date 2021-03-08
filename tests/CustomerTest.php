<?php

namespace ChinLeung\Converge\Tests;

use ChinLeung\Converge\Customer;
use Illuminate\Support\Arr;
use Orchestra\Testbench\TestCase;

class CustomerTest extends TestCase
{
    /**
     * The first name of the customer will be truncated to 20 characters.
     *
     * @test
     * @return void
     */
    public function the_first_name_will_be_truncated_to_20_characters(): void
    {
        $customer = Customer::make()->setFirstName(
            'Uvuvwevwevwe Onyetenyevwe Ugwemuhwem Osas'
        );

        $this->assertEquals(
            'Uvuvwevwevwe Onyeten',
            Arr::get($customer->toPayload(), 'ssl_first_name')
        );
    }
}
