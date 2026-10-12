
@extends('layouts.app')

@section('content')

        <div class="account-content">
        <!-- resources/views/livewire/brands-create-or-edit.blade.php -->
            <div class="row">
                <div id="flFormsGrid" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Create Brand</h4>
                                </div>                                                                        
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <form id="createBrandForm" enctype="multipart/form-data">
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-12">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                                        <span class="text-danger error-message" id="name_error"></span>
                                    </div>
                                </div>
                                {{-- <div class="form-group col-md-12">
                                    <label for="name">Redirect Url</label>
                                    <input type="text" class="form-control" id="redirect_url" name="redirect_url" placeholder="Redirect Url">
                                    <span class="text-danger error-message" id="redirect_url_error"></span>
                                </div> --}}
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-12">
                                        <label for="logo_path">Logo</label>
                                        <input type="file" class="form-control" id="logo_path" name="logo_path">
                                        <span class="text-danger error-message" id="logo_path_error"></span>
                                    </div>
                                </div>
                                <button type="button" id="CreateBrandSubmitBtn" class="btn btn-primary mt-3">Save Brand</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('script')
<script src="{{env('ASSET_URL')}}/custom/custom.js"></script>
@endsection