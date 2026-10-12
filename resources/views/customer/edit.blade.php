@extends('layouts.app')

@section('content')

            <div class="account-content">
                <div class="row">
                    <div id="flFormsGrid" class="col-lg-12 layout-spacing layout-top-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Edit Customer</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <form id="editCustomerForm">
                                    <input id="customer_id" type="hidden" value="{{ $customer->id }}">
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-6">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name"
                                                placeholder="First Name" value="{{ $customer->first_name }}">
                                            <span class="text-danger error-message" id="first_name_error"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name"
                                                placeholder="Last Name" value="{{ $customer->last_name }}">
                                            <span class="text-danger error-message" id="last_name_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-6">
                                            <label for="date_of_birth">Date of Birth</label>
                                            <input type="date" class="form-control" id="date_of_birth"
                                                name="date_of_birth" value="{{ $customer->date_of_birth }}">
                                            <span class="text-danger error-message" id="date_of_birth_error"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="email">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Email Address" value="{{ $customer->email }}">
                                            <span class="text-danger error-message" id="email_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-6">
                                            <label for="phone_number">Phone Number</label>
                                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                                placeholder="Phone Number" value="{{ $customer->phone_number }}">
                                            <span class="text-danger error-message" id="phone_number_error"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="address_line_1">Address Line 1</label>
                                            <input type="text" class="form-control" id="address_line_1"
                                                name="address_line_1" placeholder="Address Line 1"
                                                value="{{ $customer->address_line_1 }}">
                                            <span class="text-danger error-message" id="address_line_1_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-6">
                                            <label for="address_line_2">Address Line 2</label>
                                            <input type="text" class="form-control" id="address_line_2"
                                                name="address_line_2" placeholder="Address Line 2"
                                                value="{{ $customer->address_line_2 }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                placeholder="City" value="{{ $customer->city }}">
                                            <span class="text-danger error-message" id="city_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-6">
                                            <label for="state_province">State/Province</label>
                                            <input type="text" class="form-control" id="state_province"
                                                name="state_province" placeholder="State/Province"
                                                value="{{ $customer->state_province }}">
                                            <span class="text-danger error-message" id="state_province_error"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="postal_code">Postal/ZIP Code</label>
                                            <input type="text" class="form-control" id="postal_code"
                                                name="postal_code" placeholder="Postal/ZIP Code"
                                                value="{{ $customer->postal_code }}">
                                            <span class="text-danger error-message" id="postal_code_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-6">
                                            <label for="country">Country</label>
                                            <input type="text" class="form-control" id="country" name="country"
                                                placeholder="Country" value="{{ $customer->country }}">
                                            <span class="text-danger error-message" id="country_error"></span>
                                        </div>
                                    </div>
                                    <button type="button" id="updateBtn" class="btn btn-primary mt-3">Update
                                        Customer</button>
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

            $('#updateBtn').click(function() {
                var customerId = $('#customer_id').val(); // Get customer ID from hidden field
                $.ajax({
                    type: 'PUT', // Use PUT method for update
                    url: '/customers/' + customerId, // Update the URL to include customer ID
                    data: $('#editCustomerForm').serialize(),
                    success: function(response) {
                        // Show Snackbar notification
                        Snackbar.show({
                            text: 'Customer updated successfully.',
                            duration: 5000, // 5 seconds
                        });
                    },
                    error: function(xhr, status, error) {
                        var err = JSON.parse(xhr.responseText);
                        console.log('Error:', err);

                        // Display validation errors
                        $.each(err.errors, function(key, value) {
                            $('#' + key + '_error').text(value);
                        });
                    }
                });
            });
        });
    </script>
@endsection
