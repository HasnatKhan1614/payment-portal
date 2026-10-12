<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'uid' => 'CUST-1001',
                'first_name' => 'Alice',
                'last_name' => 'Johnson',
                'date_of_birth' => '1990-04-12',
                'email' => 'alice.johnson@example.com',
                'phone_number' => '+1-555-0101',
                'address_line_1' => '123 Maple Street',
                'address_line_2' => 'Apt 4B',
                'city' => 'Austin',
                'state_province' => 'TX',
                'postal_code' => '78701',
                'country' => 'US',
            ],
            [
                'uid' => 'CUST-1002',
                'first_name' => 'Brian',
                'last_name' => 'Smith',
                'date_of_birth' => '1985-09-03',
                'email' => 'brian.smith@example.com',
                'phone_number' => '+1-555-0102',
                'address_line_1' => '456 Oak Avenue',
                'address_line_2' => null,
                'city' => 'Denver',
                'state_province' => 'CO',
                'postal_code' => '80202',
                'country' => 'US',
            ],
            [
                'uid' => 'CUST-1003',
                'first_name' => 'Chloe',
                'last_name' => 'Williams',
                'date_of_birth' => '1994-01-22',
                'email' => 'chloe.williams@example.com',
                'phone_number' => '+1-555-0103',
                'address_line_1' => '789 Pine Road',
                'address_line_2' => 'Suite 200',
                'city' => 'Seattle',
                'state_province' => 'WA',
                'postal_code' => '98101',
                'country' => 'US',
            ],
            [
                'uid' => 'CUST-1004',
                'first_name' => 'David',
                'last_name' => 'Brown',
                'date_of_birth' => '1988-11-15',
                'email' => 'david.brown@example.com',
                'phone_number' => '+44-7700-900123',
                'address_line_1' => '10 High Street',
                'address_line_2' => null,
                'city' => 'London',
                'state_province' => 'England',
                'postal_code' => 'SW1A 1AA',
                'country' => 'GB',
            ],
            [
                'uid' => 'CUST-1005',
                'first_name' => 'Emma',
                'last_name' => 'Davis',
                'date_of_birth' => '1992-07-08',
                'email' => 'emma.davis@example.com',
                'phone_number' => '+1-555-0105',
                'address_line_1' => '321 Cedar Lane',
                'address_line_2' => null,
                'city' => 'Chicago',
                'state_province' => 'IL',
                'postal_code' => '60601',
                'country' => 'US',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::updateOrCreate(
                ['email' => $customer['email']],
                array_merge($customer, [
                    'uid' => $customer['uid'] ?? Str::upper(Str::random(8)),
                ])
            );
        }
    }
}
