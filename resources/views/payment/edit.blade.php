@extends('layouts.app')

@section('content')

            <div class="account-content">
                <!-- resources/views/livewire/payments-create-or-edit.blade.php -->
                <div class="row">
                    <div id="flFormsGrid" class="col-lg-12 layout-spacing layout-top-spacing ">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Update Payment Link</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area custom-overlay">
                                <form id="editPaymentForm">
                                    <input type="hidden" name="payment_id" id="payment_id" value="{{ $payment->id }}">

                                    <!-- Customer Type and Existing Customer Dropdown -->
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-12">
                                            <label for="customer_type">Customer Type</label>
                                            <select class="form-control" id="customer_type" name="customer_type" value="">
                                                <option value="0" selected> Existing Customer</option>
                                                <option value="1"> New Customer</option>
                                            </select>
                                        </div>

                                        <!-- Existing Customer Dropdown -->
                                        <div class="form-group col-md-12" id="existing_customer_fields"
                                            style="{{ $payment->customer_type == 1 ? 'display:none;' : '' }}">
                                            <label for="customer_id">Select Customer</label>
                                            <select class="form-control" id="customer_id" name="customer_id"
                                                value="{{ old('customer_id', $payment->customer_id) }}">
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}"
                                                        {{ $payment->customer_id == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->first_name }} {{ $customer->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-message" id="customer_id_error"></span>
                                        </div>
                                    </div>


                                    <div id="new_customer_fields" style="display: none;">
                                        <div class="form-row mb-4">
                                            <div class="form-group col-md-6">
                                                <label for="first_name">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" value=""
                                                    placeholder="First Name">
                                                <span class="text-danger error-message" id="first_name_error"></span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name"
                                                    placeholder="Last Name">
                                                <span class="text-danger error-message" id="last_name_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-row mb-4">
                                            <div class="form-group col-md-6">
                                                <label for="phone_number">Phone Number</label>
                                                <input type="text" class="form-control" id="phone_number"
                                                    name="phone_number" placeholder="Phone Number">
                                                <span class="text-danger error-message" id="phone_number_error"></span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">Email Address</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Email Address">
                                                <span class="text-danger error-message" id="email_error"></span>
                                            </div>
                                        </div>




                                    </div>

                                    <!-- Gateway and Brand Selection -->
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-6">
                                            <label for="gateway_id">Gateway</label>
                                            <select class="form-control" id="gateway_id" name="gateway_id"
                                                value="{{ $payment->gateway_id }}">
                                                @foreach ($gateways as $gateway)
                                                    <option value="{{ $gateway->id }}">{{ $gateway->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-message" id="gateway_id_error"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="brand_id">Brand</label>
                                            <select class="form-control" id="brand_id" name="brand_id"
                                                value="{{ $payment->brand_id }}">
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-message" id="brand_id_error"></span>
                                        </div>
                                    </div>

                                    <!-- Invoice Number and Package Name -->
                                    <div class="form-row mb-4">
                                        {{-- <div class="form-group col-md-6">
                                            <label for="invoice_number">Invoice Number</label>
                                            <input value="" type="text" class="form-control"
                                                id="invoice_number" name="invoice_number" value="{{$payment->invoice_number}}" placeholder="Invoice Number">
                                            <span class="text-danger error-message" id="invoice_number_error"></span>
                                        </div> --}}
                                        <div class="form-group col-md-12">
                                            <label for="package_name">Package Name</label>
                                            <input type="text" class="form-control" id="package_name"
                                                name="package_name" value="{{ $payment->package_name }}"
                                                placeholder="Package Name">
                                            <span class="text-danger error-message" id="package_name_error"></span>
                                        </div>
                                    </div>

                                    <!-- Description and Currency -->
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-6">
                                            <label for="description">Description</label>
                                            <input type="text" class="form-control" id="description"
                                                name="description" value="{{ $payment->description }}"
                                                placeholder="Description">
                                            <span class="text-danger error-message" id="description_error"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="currency">Currency</label>
                                            <select class="form-control" id="currency" name="currency"
                                                value="{{ $payment->currency }}">
                                                <option value="usd" selected>USD</option>
                                                <option value="gbp">GBP</option>
                                            </select>
                                            <span class="text-danger error-message" id="currency_error"></span>
                                        </div>
                                    </div>

                                    <!-- Price and Tax -->
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-6">
                                            <label for="price">Price</label>
                                            <input type="text" class="form-control" id="price" name="price"
                                                value="{{ $payment->price }}" placeholder="Price">
                                            <span class="text-danger error-message" id="price_error"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="tax">Tax (%)</label>
                                            <input type="number" class="form-control" id="tax" name="tax"
                                                value="{{ $payment->tax }}" placeholder="Tax" value="0">
                                            <span class="text-danger error-message" id="tax_error"></span>
                                        </div>
                                    </div>

                                    <!-- Remaining and Submit Button -->
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-6">
                                            <label for="remaining">Remaining</label>
                                            <input type="number" class="form-control" id="remaining" name="remaining"
                                                value="{{ $payment->remaining }}" placeholder="Remaining"
                                                value="0">
                                            <span class="text-danger error-message" id="remaining_error"></span>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-12">
                                            <button type="button" id="updateBtn" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Set CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#updateBtn').click(function(e) {
                e.preventDefault();

                var block = $('.custom-overlay');

                // Display the loading overlay
                $(block).block({
                    message: 'Loading....',
                    overlayCSS: {
                        backgroundColor: '#515365',
                        opacity: 0.9,
                        cursor: 'wait'
                    },
                    css: {
                        border: 0,
                        padding: 0,
                        color: '#fff',
                        backgroundColor: 'transparent'
                    }
                });

                var paymentId = $('#payment_id').val(); // Get payment ID from hidden field
                console.log(paymentId)
                $.ajax({
                    type: 'PUT', // Use PUT method for update
                    url: '/payments/' + paymentId, // Update the URL to include payment ID
                    data: $('#editPaymentForm').serialize(),
                    success: function(response) {
                        // Clear form fields
                        $('#editPaymentForm')[0].reset();

                        // Show Snackbar notification
                        Snackbar.show({
                            text: 'Payment Link updated successfully.',
                            duration: 5000, // 5 seconds
                        });

                        // Redirect after 2 seconds
                        setTimeout(function() {
                            $(block).unblock();
                            window.location.href = response.link;
                        }, 2000);
                    },
                    error: function(xhr) {
                        var err = JSON.parse(xhr.responseText);
                        console.log('Error:', err);

                        // Display validation errors
                        $.each(err.errors, function(key, value) {
                            $('#' + key + '_error').text(value);
                        });

                        // Unblock the loader after error handling
                        $(block).unblock();
                    }
                });
            });

        });
    </script>
    <!-- JavaScript to Toggle New Customer Fields -->
    <script>
        document.getElementById('customer_type').addEventListener('change', function() {
            var existingCustomerFields = document.getElementById('existing_customer_fields');
            var newCustomerFields = document.getElementById('new_customer_fields');

            if (this.value === '1') {
                // Show new customer fields and hide existing customer dropdown
                newCustomerFields.style.display = 'block';
                existingCustomerFields.style.display = 'none';
            } else {
                // Show existing customer dropdown and hide new customer fields
                newCustomerFields.style.display = 'none';
                existingCustomerFields.style.display = 'block';
            }
        });
    </script>
    <script>
        var block = $('#custom-overlay');
        $(block).block({
            message: 'Loading....',
            timeout: 2000, //unblock after 2 seconds
            overlayCSS: {
                backgroundColor: '#515365',
                opacity: 0.9,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                color: '#fff',
                backgroundColor: 'transparent'
            }
        });
    </script>
@endsection
