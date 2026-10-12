<?php

namespace Database\Seeders;

use App\Models\Gateway;
use Illuminate\Database\Seeder;

class GatewaySeeder extends Seeder
{
    public function run(): void
    {
        $gateways = [
            [
                'type' => 'stripe',
                'name' => 'Stripe Sandbox',
                'sort_order' => 1,
                'status' => true,
                'key1' => 'pk_test_dummy_publishable_key',
                'key2' => 'sk_test_dummy_secret_key',
                'key3' => null,
            ],
            [
                'type' => 'paypal',
                'name' => 'PayPal Sandbox',
                'sort_order' => 2,
                'status' => true,
                'key1' => 'dummy_paypal_client_id',
                'key2' => 'dummy_paypal_client_secret',
                'key3' => null,
            ],
            [
                'type' => 'authorize',
                'name' => 'Authorize.Net Sandbox',
                'sort_order' => 3,
                'status' => true,
                'key1' => 'dummy_authorize_api_login_id',
                'key2' => 'dummy_authorize_transaction_key',
                'key3' => 'dummy_authorize_signature_key',
            ],
        ];

        foreach ($gateways as $gateway) {
            Gateway::updateOrCreate(
                ['name' => $gateway['name']],
                $gateway
            );
        }
    }
}
