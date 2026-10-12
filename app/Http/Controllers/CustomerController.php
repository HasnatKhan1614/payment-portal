<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'DESC')
            ->get();

        return view('customer.index', ['customers' => $customers]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Customer::$rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Generate a UID for the customer
        $uid = mt_rand(10000000, 99999999);

        // Add the UID to the request data
        $requestData = $request->all();
        $requestData['uid'] = $uid;

        // Create the customer with the UID included
        $customer = Customer::create($requestData);

        if ($customer) {
            return response()->json(['message' => 'Customer created successfully', 'customer' => $customer], 201);
        } else {
            return response()->json(['message' => 'Failed to create customer'], 500);
        }
    }


    public function create()
    {
        return view('customer.create');
    }

    public function edit($id)
    {
        $customer = Customer::find($id);

        return view('customer.edit', ['customer' => $customer]);
    }

    public function show(Customer $customer)
    {
        return $customer;
    }

    public function update(Request $request, Customer $customer)
    {
        $validator = Validator::make($request->all(), Customer::$rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $customer->update($request->all());

        if ($customer) {
            return response()->json(['message' => 'Customer updated successfully', 'customer' => $customer], 200);
        } else {
            return response()->json(['message' => 'Failed to update customer'], 500);
        }
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);

        $customer->delete();
        return back()->with('message', 'Customer deleted successfully');
    }
}

