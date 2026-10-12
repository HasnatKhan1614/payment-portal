@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css"
    integrity="sha384-BY+fdrpOd3gfeRvTSMT+VUZmA728cfF9Z2G42xpaRkUGu2i3DyzpTURDo5A6CaLK" crossorigin="anonymous">
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-spacing layout-top-spacing" id="cancel-row">
            <div class="col-lg-12">
                <div class="widget-content searchable-container list">
                    <div class="row">
                        <div class="col-12 layout-spacing mb-2">
                            <div class="d-flex flex-wrap align-items-center w-100">
                                <div class="page-title mb-0">
                                    <h3 class="mb-0">Payments</h3>
                                </div>
                                <div class="d-flex flex-wrap align-items-center ml-auto">
                                    <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#paymentsFiltersModal">
                                        Filters
                                    </button>
                                    <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Reset filters</a>
                                </div>
                            </div>
                            <hr class="my-3">

                            <form action="{{ route('payments.index') }}" method="GET">
                                <div class="modal fade" id="paymentsFiltersModal" tabindex="-1" role="dialog" aria-labelledby="paymentsFiltersModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="paymentsFiltersModalLabel">Payment filters</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label for="start_date" class="form-label">From</label>
                                                        <input value="{{ request('start_date') }}" class="form-control" type="date" name="start_date" id="start_date">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="end_date" class="form-label">To</label>
                                                        <input value="{{ request('end_date') }}" class="form-control" type="date" name="end_date" id="end_date">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select name="status" id="status" class="form-control">
                                                            <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>All</option>
                                                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                                                            <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                                        </select>
                                                    </div>
                                                    @if ($isAdmin)
                                                    <div class="col-md-6">
                                                        <label for="seller_id" class="form-label">Seller</label>
                                                        <select name="seller_id" id="seller_id" class="form-control">
                                                            <option value="">All sellers</option>
                                                            @foreach ($sellers as $seller)
                                                                <option value="{{ $seller->id }}" {{ (string) request('seller_id') === (string) $seller->id ? 'selected' : '' }}>
                                                                    {{ $seller->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @endif
                                                    <div class="col-md-6">
                                                        <label for="gateway_id" class="form-label">Gateway</label>
                                                        <select name="gateway_id" id="gateway_id" class="form-control">
                                                            <option value="">All gateways</option>
                                                            @foreach ($gateways as $gateway)
                                                                <option value="{{ $gateway->id }}" {{ (string) request('gateway_id') === (string) $gateway->id ? 'selected' : '' }}>
                                                                    {{ $gateway->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="brand_id" class="form-label">Brand</label>
                                                        <select name="brand_id" id="brand_id" class="form-control">
                                                            <option value="">All brands</option>
                                                            @foreach ($brands as $brand)
                                                                <option value="{{ $brand->id }}" {{ (string) request('brand_id') === (string) $brand->id ? 'selected' : '' }}>
                                                                    {{ $brand->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-end">
                                                <button type="button" class="btn btn-light mr-2" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Apply filters</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row layout-top-spacing" id="cancel-row">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ url('/payments/create') }}" class="btn"
                            style="background-color: #000000;color:white;">Create</a>
                    </div>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="table" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>User</th>
                                    <th>Gateway</th>
                                    <th>Brand</th>
                                    <th>Invoice Number</th>
                                    <!--<th>Description</th>-->
                                    <!--<th>Currency</th>-->
                                    <th>Price</th>
                                    <th>Tax</th>
                                    <th>Remaining</th>
                                    <th>Total</th>
                                    <th>Date</th>

                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $key => $payment)
                                @php
                                $taxAmount = ($payment->price * $payment->tax) / 100;
                                $totalAmount = $payment->price + $taxAmount;
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $payment->customer->first_name ?? 'N/A' }} {{ $payment->customer->last_name ?? '' }}</td>
                                    <td>{{ $payment->user->name ?? 'N/A' }}</td>
                                    <td>{{ $payment->gateway->name ?? 'N/A' }}</td>
                                    <td>{{ $payment->brand->name ?? 'N/A' }}</td>
                                    <td>{{ $payment->invoice_number ?? 'N/A' }}</td>
                                    <!--<td>{{ $payment->description }}</td>-->
                                    <!--<td>-->
                                    <!--    {{ $payment->currency }}-->
                                    <!--</td>-->
                                    <td>
                                        {{ $payment->price ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ round($payment->tax) }}%
                                    </td>

                                    <td>
                                        {{ $payment->currency == 'usd' ? '$' : '' }}
                                        {{ $payment->currency == 'gbp' ? '£' : '' }}
                                        {{ $payment->remaining }}
                                    </td>
                                    <td>
                                        {{ $payment->currency == 'usd' ? '$' : '' }}
                                        {{ $payment->currency == 'gbp' ? '£' : '' }}
                                        {{ $totalAmount }}

                                    </td>
                                    <td>
                                        {{ $payment->created_at->format('d M Y, h:i A') }}


                                    </td>
                                    <td><span
                                            class="badge {{ $payment->status == 'unpaid' ? 'bg-danger' : 'bg-success' }}">{{
                                            $payment->status }}</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="/invoice/{{ $payment->invoice_number ?? 'N/A' }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                                                    <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                                                    <path
                                                        d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1" />
                                                </svg>
                                                <span class="visually-hidden">Print</span>
                                            </a>
                                            <a href="{{ url('/proceed/' . $payment->invoice_number ?? 'N/A') }}"
                                                class="btn btn-sm btn-outline-dark copyLink"
                                                data-invoice="{{ $payment->invoice_number ?? 'N/A' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-link-45deg" viewBox="0 0 16 16">
                                                    <path
                                                        d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1 1 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4 4 0 0 1-.128-1.287z" />
                                                    <path
                                                        d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243z" />
                                                </svg>
                                                <span class="visually-hidden">Link</span>
                                            </a>
                                            @if ($payment->status !== 'paid')
                                            <a href="{{ route('payments.edit', $payment->id) }}"
                                                class="btn btn-sm btn-outline-warning ">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                    <path
                                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                                </svg>
                                                <span class="visually-hidden">Edit</span>
                                            </a>
                                            <form action="{{ route('payments.destroy', $payment->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this payment?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path
                                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z">
                                                        </path>
                                                        <path
                                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z">
                                                        </path>
                                                    </svg>
                                                    <span class="visually-hidden">Delete</span>
                                                </button>
                                            </form>
                                            @endif

                                        </div>
                                    </td>

                                </tr> @endforeach
                            </tbody>
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
    document.addEventListener('DOMContentLoaded', function () {
        var copyLinkBtns = document.querySelectorAll('.copyLink');

        copyLinkBtns.forEach(function (copyLinkBtn) {
            copyLinkBtn.addEventListener('click', function (event) {
                // Prevent the default link behavior
                event.preventDefault();

                // Get the URL from the link's href attribute
                var url = copyLinkBtn.getAttribute('href');

                // Create a temporary input element to copy the URL
                var input = document.createElement('input');
                input.setAttribute('value', url);
                document.body.appendChild(input);

                // Select the input element and copy its value to the clipboard
                input.select();
                document.execCommand('copy');

                // Remove the temporary input element
                document.body.removeChild(input);

                // Optionally, provide feedback to the user
                alert('URL copied to clipboard: ' + url);
            });
        });
    });
</script>
@endsection