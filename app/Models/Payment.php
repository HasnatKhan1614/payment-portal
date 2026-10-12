<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    protected $fillable = [
        'user_id',
        'customer_id',
        'gateway_id',
        'brand_id',
        'invoice_number',
        'payment_confirmed_at',
        'package_name',
        'description',
        'price',
        'currency',
        'status',
        'tax',
        'remaining',
        'session_id',
    ];

    public static $rules = [
        'customer_type' => 'required|in:0,1', // 0 = Existing Customer, 1 = New Customer
        'customer_id' => 'required_if:customer_type,0|exists:customers,id',
        'first_name' => 'required_if:customer_type,1|nullable|string|max:255',
        'last_name' => 'nullable|string|max:255', // Always nullable
        'email' => 'nullable|email|max:255', // Always nullable
        'phone_number' => 'nullable|string|max:20', // Always nullable
        'gateway_id' => 'required|exists:gateways,id',
        'brand_id' => 'required|exists:brands,id',
        'package_name' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
        'currency' => 'required|in:usd,gbp',
        'price' => 'required|numeric|min:0',
        'tax' => 'nullable|numeric|min:0',
        'remaining' => 'nullable|numeric|min:0',
    ];
}
