@extends('layouts.app')

@section('content')
<div class="account-content">
    <div class="row">
        <div id="flFormsGrid" class="col-lg-12 layout-spacing layout-top-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Set Primary Email</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <form id="createPrimaryEmailForm">
                        <div class="form-row mb-4">
                            <div class="form-group col-md-12">
                                <label for="primary_email">Email</label>
                                <input type="email" class="form-control" id="primary_email"
                                    name="primary_email"
                                    value="{{ isset($setting->primary_email) ? $setting->primary_email : '' }}"
                                    placeholder="Email">
                                <span class="text-danger error-message" id="primary_email_error"></span>
                            </div>
                        </div>
                        <button type="button" id="createPrimaryEmailSubmitBtn"
                            class="btn btn-primary mt-3">Save Email</button>
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
