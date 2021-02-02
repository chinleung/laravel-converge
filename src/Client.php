<?php

namespace ChinLeung\Converge;

use ChinLeung\Converge\Contracts\Chargeable;
use ChinLeung\Converge\Exceptions\CardException;
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
     * Charge a token or card.
     *
     * @link  https://developer.elavon.com/na/docs/converge/1.0.0/integration-guide/transaction_types/credit_card/sale
     *
     * @param  \ChinLeung\Converge\Contracts\Chargeable  $chargeable
     * @param  int  $amount
     * @param  array  $options
     * @return \ChinLeung\Converge\Charge
     */
    public function charge(Chargeable $chargeable, int $amount, array $options = []): Charge
    {
        $response = $this->send('ccsale', array_merge(
            $chargeable->toPayload(),
            $options,
            [
                'ssl_amount' => $amount / 100,
            ]
        ));

        if ($response->get('ssl_result') === '1') {
            throw new CardException($response->get('ssl_result_message'));
        }

        return new Charge($response);
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
     * Generate a token for a card.
     *
     * @link  https://developer.elavon.com/na/docs/converge/1.0.0/integration-guide/transaction_types/card_manager/generate_token
     *
     * @param  \ChinLeung\Converge\Card  $card
     * @param  array  $options
     * @return \ChinLeung\Converge\Token
     */
    public function generateToken(Card $card, array $options): Token
    {
        $response = $this->send('ccgettoken', array_merge(
            $card->toPayload(),
            $options
        ));

        return new Token($response->get('ssl_token'));
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
     * Refund a transaction.
     *
     * @link  https://developer.elavon.com/na/docs/converge/1.0.0/integration-guide/transaction_types/credit_card/return
     *
     * @param  string  $id
     * @param  int  $amount
     * @return \ChinLeung\Converge\Http\Response
     */
    public function refund(string $id, int $amount = null): Response
    {
        return $this->send('ccreturn', array_filter([
            'ssl_txn_id' => $id,
            'ssl_amount' => $amount / 100,
        ]));
    }

    /**
     * Save a token to the vault for a card.
     *
     * @link  https://developer.elavon.com/na/docs/converge/1.0.0/integration-guide/transaction_types/card_manager/generate_token
     *
     * @param  \ChinLeung\Converge\Card  $card
     * @param  array  $options
     * @return \ChinLeung\Converge\Token
     */
    public function saveToken(Card $card, array $options): Token
    {
        return $this->generateToken($card, array_merge($options, [
            'ssl_add_token' => 'Y',
        ]));
    }

    /**
     * Send the request to Converge's api.
     *
     * @param  string  $action
     * @param  array  $options
     * @return \ChinLeung\Converge\Http\Response
     */
    protected function send(string $action, array $options = []): Response
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
