@extends('layouts.app')

@section('content')

            <div class="account-content">
                <!-- resources/views/livewire/user-create-or-edit.blade.php -->
                <div class="row">
                    <div id="flFormsGrid" class="col-lg-12 layout-spacing layout-top-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Create User</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <form id="createUserForm">

                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-6">
                                            <label for="name">Type</label>
                                            <select name="is_admin" id="is_admin" class="form-control">
                                                <option value="1">Admin</option>
                                                <option value="0">User</option>
                                            </select>
                                            <span class="text-danger error-message" id="name_error"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Name">
                                            <span class="text-danger error-message" id="name_error"></span>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="email">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Email Address">
                                            <span class="text-danger error-message" id="email_error"></span>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Password">
                                            <span class="text-danger error-message" id="password_error"></span>
                                        </div>
                                    </div>
                                    <button type="button" id="CreateUserSubmitBtn" class="btn btn-primary mt-3">Save
                                        User</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@endsection

@section('script')
    <script src="{{ env('ASSET_URL') }}/custom/custom.js"></script>
@endsection
