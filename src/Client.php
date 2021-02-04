<?php

namespace ChinLeung\Converge;

use ChinLeung\Converge\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use SimpleXMLElement;

class Client
{
    /**
     * The endpoint of Converge's api.
     *
     * @var string
     */
    protected $endpoint = 'https://api.convergepay.com/VirtualMerchantDemo/processxml.do';

    /**
     * The merchant id of the account.
     *
     * @var string
     */
    protected $id;

    /**
     * The user id.
     *
     * @var string
     */
    protected $user;

    /**
     * The pin of the user.
     *
     * @var string
     */
    protected $pin;

    /**
     * Create a new instance of the client.
     *
     * @param  string  $id
     * @param  string  $user
     * @param  string  $pin
     * @param  bool  $demo
     */
    public function __construct(string $id, string $user, string $pin, bool $demo = false)
    {
        $this->id = $id;
        $this->user = $user;
        $this->pin = $pin;

        if ($demo === true) {
            $this->demo();
        }
    }

    /**
     * Update the client's endpoint to use the demo environment endpoint.
     *
     * @return void
     */
    protected function demo(): void
    {
        $this->endpoint = str_replace(
            'api.convergepay',
            'api.demo.convergepay',
            $this->endpoint
        );
    }

    /**
     * Generate the XML payload based on the given options.
     *
     * @param  string  $action
     * @param  array  $options
     * @return string
     */
    protected function generatePayload(string $action, array $options = []): string
    {
        return Str::after($this->toXml(array_merge([
            'ssl_merchant_id' => $this->id,
            'ssl_user_id' => $this->user,
            'ssl_pin' => $this->pin,
            'ssl_transaction_type' => $action,
        ], $options)), "\n");
    }

    /**
     * Retrieve the endpoint of the client.
     *
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * Send the request to Converge's api.
     *
     * @param  string  $action
     * @param  array  $options
     * @return \ChinLeung\Converge\Http\Response
     */
    public function send(string $action, array $options = []): Response
    {
        $payload = $this->generatePayload($action, $options);

        return new Response(Http::asForm()->post($this->endpoint, [
            'xmldata' => $payload,
        ]));
    }

    /**
     * Convert an array of data into xml.
     *
     * @param  array  $data
     * @param  string  $root
     * @param  \SimpleXMLElement  $instance
     * @return string
     */
    protected function toXml(array $data, string $root = '<txn/>', SimpleXMLElement $instance = null): string
    {
        $xml = $instance ?? new SimpleXMLElement($root);

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $this->toXml($value, $key, $xml->addChild($key));
                continue;
            }

            $xml->addChild($key, $value);
        }

        return $xml->asXML();
    }
}
