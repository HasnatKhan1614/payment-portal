
@extends('layouts.app')

@section('content')
<div id="content" class="main-content">
    <div class="container">
        <div class="container">
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
                            <form id="editBrandForm" enctype="multipart/form-data">
                                <div class="form-row mb-4">
                                    <input id="brand_id" type="hidden" value="{{$brand->id}}">
                                    <div class="form-group col-md-12">
                                        <label for="name">Name</label>
                                        <input value="{{$brand->name}}" type="text" class="form-control" id="name" name="name" placeholder="Name">
                                        <span class="text-danger error-message" id="name_error"></span>
                                    </div>
                                    {{-- <div class="form-group col-md-12">
                                        <label for="name">Redirect Url</label>
                                        <input value="{{$brand->redirect_url}}" type="text" class="form-control" id="redirect_url" name="redirect_url" placeholder="Redirect Url">
                                        <span class="text-danger error-message" id="redirect_url_error"></span>
                                    </div> --}}
                                </div>
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-12">
                                        <label for="logo_path">Logo</label>
                                        <input type="file" class="form-control" id="logo_path" name="logo_path">
                                        <span class="text-danger error-message" id="logo_path_error"></span>
                                    </div>
                                </div>
                                <button type="button" id="updateBtn" class="btn btn-primary mt-3">Save Brand</button>
                            </form>
                        </div>
                    </div>
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
            var brandId = $('#brand_id').val(); // Get brand ID from hidden field
            var formData = new FormData($("#editBrandForm")[0]); // Convert form to FormData

            $.ajax({
                type: 'POST', // Laravel requires POST for file uploads even during updates
                url: '/brands/' + brandId + '?_method=PUT', // Simulate PUT request using query param
                data: formData,
                processData: false, // Prevent jQuery from processing data
                contentType: false, // Prevent jQuery from setting contentType
                success: function(response) {
                    Snackbar.show({
                        text: 'Brand updated successfully.',
                        duration: 5000 // 5 seconds
                    });
                },
                error: function(xhr, status, error) {
                    try {
                        var err = JSON.parse(xhr.responseText);
                        // Display validation errors
                        $.each(err.errors, function(key, value) {
                            $('#' + key + '_error').text(value);
                        });
                    } catch (e) {
                        console.error("Unexpected Error: ", e);
                    }
                }
            });
        });
    });
</script>

@endsection