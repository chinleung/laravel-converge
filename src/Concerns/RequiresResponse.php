<?php

namespace ChinLeung\Converge\Concerns;

use ChinLeung\Converge\Http\Response;

trait RequiresResponse
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
}
