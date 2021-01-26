<?php

namespace ChinLeung\Converge\Tests;

use ChinLeung\Converge\Card;
use Orchestra\Testbench\TestCase;

class CardTest extends TestCase
{
    /**
     * A card can be converted to a request payload properly.
     *
     * @test
     * @return void
     */
    public function the_payload_will_be_correct(): void
    {
        $card = new Card('1234123412341234', '1221', '345');

        $this->assertEquals([
            'ssl_card_number' => '1234123412341234',
            'ssl_exp_date' => '1221',
            'ssl_cvv2cvc2' => '345',
        ], $card->toPayload());
    }
}
