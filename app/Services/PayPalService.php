<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PayPalService
{
    protected $client;
    protected $clientId;
    protected $clientSecret;
    protected $mode;

    public function __construct()
    {
        $this->client = new Client();
        $this->clientId = config('paypal.client_id');
        $this->clientSecret = config('paypal.client_secret');
        $this->mode = config('paypal.mode');
    }

    protected function getBaseUri()
    {
        return $this->mode === 'sandbox'
            ? 'https://api.sandbox.paypal.com'
            : 'https://api.paypal.com';
    }

    protected function getAuthToken()
    {
        $response = $this->client->post($this->getBaseUri() . '/v1/oauth2/token', [
            'auth' => [$this->clientId, $this->clientSecret],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ]);

        return json_decode($response->getBody(), true)['access_token'];
    }

    public function createInvoice($invoiceData)
    {
        $token = $this->getAuthToken();
        dd($token);

        $response = $this->client->post('https://api-m.sandbox.paypal.com/v2/invoicing/invoices', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ],
            'json' => $invoiceData,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function sendInvoice($invoiceId)
    {
        $token = $this->getAuthToken();

        $response = $this->client->post($this->getBaseUri() . '/v2/invoicing/invoices/' . $invoiceId . '/send', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function generateCheckoutLink($invoiceId)
    {
        $token = $this->getAuthToken();

        $response = $this->client->post($this->getBaseUri() . '/v2/invoicing/invoices/' . $invoiceId . '/send', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ],
        ]);

        $responseData = json_decode($response->getBody(), true);

        // Extract the checkout link from the response
        foreach ($responseData['links'] as $link) {
            if ($link['rel'] === 'payer_view_url') {
                return $link['href'];
            }
        }

        throw new \Exception('Checkout link not found in the response.');
    }


}