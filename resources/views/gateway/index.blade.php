@extends('layouts.app')

@section('content')
    <style>
        .gateway-drag-handle {
            cursor: move;
            color: #3b3f5c;
            font-size: 18px;
            line-height: 1;
            user-select: none;
        }
        #gateway-order-table tbody tr.ui-sortable-helper {
            background: #fff;
        }
    </style>
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
                                        <a href="{{ url('/gateways/create') }}" class="btn"
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
                            <table id="gateway-order-table" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>#</th>
                                        <th>Order</th>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="gateway-sortable-body">
                                @foreach ($gateways as $key => $brand)
                                    <tr data-gateway-id="{{ $brand->id }}">
                                        <td><span class="gateway-drag-handle">⋮⋮</span></td>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $brand->sort_order ?? 0 }}</td>
                                        <td>{{ $brand->type }}</td>
                                        <td>{{ $brand->name }}</td>
                                        <td>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                    class="custom-control-input gateway-status-toggle"
                                                    id="gateway-status-{{ $brand->id }}"
                                                    data-id="{{ $brand->id }}"
                                                    {{ ($brand->status ?? 1) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="gateway-status-{{ $brand->id }}">
                                                    {{ ($brand->status ?? 1) ? 'Active' : 'Inactive' }}
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <!-- Edit Button -->
                                            <a href="{{ route('gateways.edit', $brand->id) }}"
                                                class="btn btn-primary">Edit</a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('gateways.destroy', $brand->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this brand?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>#</th>
                                        <th>Order</th>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Status</th>
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
<script>
    $(document).ready(function () {
        var $tbody = $('#gateway-sortable-body');
        if (!$tbody.length || typeof $tbody.sortable !== 'function') {
            return;
        }

        function saveGatewayOrder() {
            var gatewayIds = $tbody.find('tr').map(function () {
                return $(this).data('gateway-id');
            }).get();

            $.ajax({
                type: 'POST',
                url: '{{ route('gateways.reorder') }}',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    gateway_ids: gatewayIds
                },
                success: function () {
                    $tbody.find('tr').each(function (index) {
                        $(this).find('td').eq(1).text(index + 1);
                        $(this).find('td').eq(2).text(index + 1);
                    });
                    Snackbar.show({
                        text: 'Gateway order updated.',
                        duration: 3000
                    });
                }
            });
        }

        $tbody.sortable({
            handle: '.gateway-drag-handle',
            update: saveGatewayOrder
        });

        $('.gateway-status-toggle').on('change', function () {
            var $toggle = $(this);
            var gatewayId = $toggle.data('id');
            var isChecked = $toggle.is(':checked');
            var $label = $('label[for="gateway-status-' + gatewayId + '"]');

            $.ajax({
                type: 'POST',
                url: '/gateways/' + gatewayId + '/status',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: isChecked ? 1 : 0
                },
                success: function (response) {
                    $label.text(response.status ? 'Active' : 'Inactive');
                    Snackbar.show({
                        text: 'Gateway status updated.',
                        duration: 2500
                    });
                },
                error: function () {
                    $toggle.prop('checked', !isChecked);
                    $label.text(!isChecked ? 'Active' : 'Inactive');
                    Snackbar.show({
                        text: 'Failed to update status.',
                        duration: 2500
                    });
                }
            });
        });
    });
</script>
@endsection
