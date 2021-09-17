<?php

namespace ChinLeung\Converge\Tests;

use ChinLeung\Converge\Token;
use Orchestra\Testbench\TestCase;

class TokenTest extends TestCase
{
    /**
     * A token can be converted to a request payload properly.
     *
     * @test
     *
     * @return void
     */
    public function the_payload_will_be_correct(): void
    {
        $token = new Token('123456789');

        $this->assertEquals([
            'ssl_token' => '123456789',
        ], $token->toPayload());
    }
}
