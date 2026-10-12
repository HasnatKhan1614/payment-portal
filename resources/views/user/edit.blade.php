@extends('layouts.app')

@section('content')

            <div class="account-content">
                <div class="row">
                    <div id="flFormsGrid" class="col-lg-12 layout-spacing layout-top-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Edit User</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <form id="editUserForm">
                                    <input id="user_id" type="hidden" value="{{ $user->id }}">
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-6">
                                            <label for="is_admin">Type</label>
                                            <select name="is_admin" id="is_admin" class="form-control">
                                                <option value="1" {{ $user->is_admin == 1 ? 'selected' : '' }}>Admin
                                                </option>
                                                <option value="0" {{ $user->is_admin == 0 ? 'selected' : '' }}>User
                                                </option>
                                            </select>
                                            <span class="text-danger error-message" id="name_error"></span>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Name" value="{{ $user->name }}">
                                            <span class="text-danger error-message" id="name_error"></span>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="email">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Email Address" value="{{ $user->email }}">
                                            <span class="text-danger error-message" id="email_error"></span>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Password" value="">
                                            <span class="text-danger error-message" id="password_error"></span>
                                        </div>
                                    </div>
                                    <button type="button" id="updateBtn" class="btn btn-primary mt-3">Update
                                        User</button>
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
                var userId = $('#user_id').val(); // Get user ID from hidden field
                $.ajax({
                    type: 'PUT', // Use PUT method for update
                    url: '/users/' + userId, // Update the URL to include user ID
                    data: $('#editUserForm').serialize(),
                    success: function(response) {
                        // Show Snackbar notification
                        Snackbar.show({
                            text: 'User updated successfully.',
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
