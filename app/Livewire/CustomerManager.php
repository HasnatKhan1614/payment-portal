<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;

class CustomerManager extends Component
{
    public $customers, $customer_id, $first_name, $last_name, $date_of_birth, $email, $phone_number, $address_line_1, $address_line_2, $city, $state_province, $postal_code, $country;
    public $isOpen = 0;

    public function render()
    {
        $this->customers = Customer::all();
        return view('livewire.customer-manager');
    }

    // Rest of the CRUD operations
}
