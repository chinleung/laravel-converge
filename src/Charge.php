<?php

namespace ChinLeung\Converge;

use ChinLeung\Converge\Http\Response;

class Charge
{
    /**
     * The response from Converge's api.
     *
     * @var \ChinLeung\Converge\Http\Response
     */
    protected $response;

    /**
     * Create a new charge instance.
     *
     * @param  \ChinLeung\Converge\Http\Response  $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
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
