<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Customer;
use App\Models\Gateway;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();
        $user = User::where('email', 'user@example.com')->first();
        $customers = Customer::all();
        $gateways = Gateway::all();
        $brands = Brand::all();

        if (!$admin || !$user || $customers->isEmpty() || $gateways->isEmpty() || $brands->isEmpty()) {
            return;
        }

        $payments = [
            [
                'user_id' => $admin->id,
                'customer_id' => $customers[0]->id,
                'gateway_id' => $gateways->firstWhere('type', 'stripe')?->id ?? $gateways[0]->id,
                'brand_id' => $brands[0]->id,
                'invoice_number' => 'INV-10001',
                'package_name' => 'Starter Plan',
                'description' => 'Monthly subscription for starter package',
                'price' => 49.99,
                'currency' => 'usd',
                'status' => 'paid',
                'tax' => 4.00,
                'remaining' => 0,
                'payment_confirmed_at' => now()->subDays(5),
            ],
            [
                'user_id' => $user->id,
                'customer_id' => $customers[1]->id,
                'gateway_id' => $gateways->firstWhere('type', 'paypal')?->id ?? $gateways[0]->id,
                'brand_id' => $brands[1]->id ?? $brands[0]->id,
                'invoice_number' => 'INV-10002',
                'package_name' => 'Pro Plan',
                'description' => 'Annual pro package',
                'price' => 199.00,
                'currency' => 'usd',
                'status' => 'pending',
                'tax' => 15.92,
                'remaining' => 199.00,
                'payment_confirmed_at' => null,
            ],
            [
                'user_id' => $admin->id,
                'customer_id' => $customers[2]->id,
                'gateway_id' => $gateways->firstWhere('type', 'authorize')?->id ?? $gateways[0]->id,
                'brand_id' => $brands[2]->id ?? $brands[0]->id,
                'invoice_number' => 'INV-10003',
                'package_name' => 'Enterprise Setup',
                'description' => 'One-time enterprise onboarding fee',
                'price' => 999.00,
                'currency' => 'usd',
                'status' => 'paid',
                'tax' => 79.92,
                'remaining' => 0,
                'payment_confirmed_at' => now()->subDays(2),
            ],
            [
                'user_id' => $user->id,
                'customer_id' => $customers[3]->id,
                'gateway_id' => $gateways->firstWhere('type', 'stripe')?->id ?? $gateways[0]->id,
                'brand_id' => $brands[0]->id,
                'invoice_number' => 'INV-10004',
                'package_name' => 'UK Support Pack',
                'description' => 'Support add-on billed in GBP',
                'price' => 79.50,
                'currency' => 'gbp',
                'status' => 'failed',
                'tax' => 0,
                'remaining' => 79.50,
                'payment_confirmed_at' => null,
            ],
            [
                'user_id' => $admin->id,
                'customer_id' => $customers[4]->id,
                'gateway_id' => $gateways->firstWhere('type', 'paypal')?->id ?? $gateways[0]->id,
                'brand_id' => $brands[1]->id ?? $brands[0]->id,
                'invoice_number' => 'INV-10005',
                'package_name' => 'Add-on Credits',
                'description' => 'Prepaid credit top-up',
                'price' => 25.00,
                'currency' => 'usd',
                'status' => 'paid',
                'tax' => 2.00,
                'remaining' => 0,
                'payment_confirmed_at' => now()->subDay(),
            ],
        ];

        foreach ($payments as $payment) {
            Payment::updateOrCreate(
                ['invoice_number' => $payment['invoice_number']],
                $payment
            );
        }
    }
}
