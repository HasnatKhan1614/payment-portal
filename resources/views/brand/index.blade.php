@extends('layouts.app')

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-spacing layout-top-spacing" id="cancel-row">
                <div class="col-lg-12">
                    <div class="widget-content searchable-container list">
                        <div class="row">
                            <div
                                class="col-xl-4 col-lg-5 col-md-5 col-sm-7 filtered-list-search layout-spacing align-self-center">
                            </div>
                            <div
                                class="col-xl-8 col-lg-7 col-md-7 col-sm-5 text-sm-right text-center layout-spacing align-self-center">
                                <div class="d-flex justify-content-sm-end justify-content-center">
                                    <div class="switch align-self-center">
                                        <a href="{{ url('/brands/create') }}" class="btn"
                                            style="background-color: #000000;color:white;">Create</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row layout-top-spacing" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="table-responsive mb-4 mt-4">
                            <table id="table" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        {{-- <th>Redirect Url</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ($brands as $key => $brand)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $brand->name }}</td>
<td>
    @if (!empty($brand->logo_path))
        <img src="{{ asset('storage/' . $brand->logo_path) }}"
             alt="Logo"
             style="width: 36px; height: 36px; object-fit: cover; border-radius: 4px; border: 1px solid #e0e6ed;">
    @else
        <span>Not Provided</span>
    @endif
</td>


                                        {{-- <td>{{ $brand->redirect_url }}</td> --}}
                                        <td>
                                            <!-- Edit Button -->
                                            <a href="{{ route('brands.edit', $brand->id) }}"
                                                class="btn btn-primary">Edit</a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('brands.destroy', $brand->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this brand?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
