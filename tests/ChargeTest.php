<?php

namespace ChinLeung\Converge\Tests;

use ChinLeung\Converge\Client;
use ChinLeung\Converge\Exceptions\CardException;
use ChinLeung\Converge\Token;
use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase;

class ChargeTest extends TestCase
{
    /**
     * A charge failure will trigger a card exception.
     *
     * @test
     * @return void
     */
    public function a_charge_failure_will_trigger_a_card_exception(): void
    {
        $client = new Client('id', 'user', 'pin', true);

        Http::fake([
            $client->getEndpoint() => Http::response(file_get_contents(
                __DIR__.'/fixtures/charge-failed-response.txt'
            )),
        ]);

        $this->expectException(CardException::class);

        $client->charge(new Token('token'), 100);
    }
}
