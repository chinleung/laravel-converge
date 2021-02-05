<?php

namespace ChinLeung\Converge\Tests;

use ChinLeung\Converge\Charge;
use ChinLeung\Converge\Client;
use ChinLeung\Converge\ConvergeServiceProvider;
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
        config([
            'converge.merchant_id' => 'merchant',
            'converge.user.id' => 'user',
            'converge.user.pin' => 'pin',
            'converge.demo' => true,
        ]);

        Http::fake([
            resolve(Client::class)->getEndpoint() => Http::response(file_get_contents(
                __DIR__.'/fixtures/charge-failed-response.txt'
            )),
        ]);

        $this->expectException(CardException::class);

        Charge::create(Token::make('token'), 100);
    }

    /**
     * Retrieve the service providers of the package.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            ConvergeServiceProvider::class,
        ];
    }
}
