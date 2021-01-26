<?php

namespace ChinLeung\Converge\Tests;

use ChinLeung\Converge\Client;
use Orchestra\Testbench\TestCase;

class ClientTest extends TestCase
{
    /**
     * The demo mode will update the client's endpoint.
     *
     * @test
     * @return void
     */
    public function the_demo_mode_will_update_the_endpoint(): void
    {
        $client = new Client('id', 'user', 'pin', true);

        $this->assertEquals(
            'https://api.demo.convergepay.com/VirtualMerchantDemo/processxml.do',
            $client->getEndpoint()
        );
    }
}
