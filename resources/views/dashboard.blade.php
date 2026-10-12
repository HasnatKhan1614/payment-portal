
@extends('layouts.app')

@section('content')
<style>
    .dashboard-stats-compact .widget-one_hybrid .widget-heading {
        padding: 10px 12px;
    }
    .dashboard-stats-compact .widget-one_hybrid .widget-heading .w-icon {
        padding: 4px 6px;
        margin-bottom: 6px;
    }
    .dashboard-stats-compact .widget-one_hybrid .widget-heading .w-icon svg {
        width: 14px !important;
        height: 14px !important;
    }
    .dashboard-stats-compact .widget-one_hybrid .widget-heading .w-value {
        font-size: 15px;
        line-height: 1.2;
    }
    .dashboard-stats-compact .widget-one_hybrid .widget-heading h5 {
        font-size: 11px;
        line-height: 1.25;
    }
    .dashboard-stats-compact .stat-col {
        margin-bottom: 0.5rem;
    }
    @media (min-width: 1200px) {
        .dashboard-stats-compact .stat-col {
            margin-bottom: 0;
        }
    }
</style>
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="page-header">
            <div class="d-flex flex-wrap align-items-center w-100">
                <div class="page-title mb-0">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="d-flex flex-wrap align-items-center ml-auto">
                    <button type="button" class="btn btn-primary mr-2 mb-0" data-toggle="modal" data-target="#dashboardFiltersModal">
                        Filters
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary mb-0">Reset filters</a>
                </div>
            </div>
            <hr class="my-3">

            <form action="{{ route('dashboard') }}" method="GET">
                <div class="modal fade" id="dashboardFiltersModal" tabindex="-1" role="dialog" aria-labelledby="dashboardFiltersModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="dashboardFiltersModalLabel">Dashboard filters</h5>
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

        <div class="row layout-top-spacing pt-2">
            <div class="col-12 layout-spacing mb-2">
                <div class="row widget-statistic g-2 dashboard-stats-compact">
                    <div class="col-6 col-md-4 col-lg-2 stat-col">
                        <div class="widget widget-one_hybrid widget-engagement">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                </div>
                                <p class="w-value">{{ number_format($paidCount) }}</p>
                                <h5 class="">Paid</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2 stat-col">
                        <div class="widget widget-one_hybrid widget-referral">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                </div>
                                <p class="w-value">{{ number_format($unpaidCount) }}</p>
                                <h5 class="">Unpaid</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2 stat-col">
                        <div class="widget widget-one_hybrid widget-engagement">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <text x="5" y="14" font-family="Arial, sans-serif" font-size="13px">$</text>
                                    </svg>
                                </div>
                                <p class="w-value">${{ number_format($usPaidAmount, 2) }}</p>
                                <h5 class="">Paid USD</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2 stat-col">
                        <div class="widget widget-one_hybrid widget-referral">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <text x="5" y="14" font-family="Arial, sans-serif" font-size="13px">$</text>
                                    </svg>
                                </div>
                                <p class="w-value">${{ number_format($usUnpaidAmount, 2) }}</p>
                                <h5 class="">Remaining USD</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2 stat-col">
                        <div class="widget widget-one_hybrid widget-engagement">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <text x="5" y="14" font-family="Arial, sans-serif" font-size="13px">£</text>
                                    </svg>
                                </div>
                                <p class="w-value">£{{ number_format($gbpPaidAmount, 2) }}</p>
                                <h5 class="">Paid GBP</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2 stat-col">
                        <div class="widget widget-one_hybrid widget-referral">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <text x="5" y="14" font-family="Arial, sans-serif" font-size="13px">£</text>
                                    </svg>
                                </div>
                                <p class="w-value">£{{ number_format($gbpUnpaidAmount, 2) }}</p>
                                <h5 class="">Remaining GBP</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <table id="table" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice</th>
                                    <th>Customer</th>
                                    <th>Seller</th>
                                    <th>Brand</th>
                                    <th>Gateway</th>
                                    <th>Total</th>
                                    <th>Currency</th>
                                    <th>Status</th>
                                    <th>Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $key => $payment)
                                    @php
                                        $taxAmount = $payment->tax ? ($payment->price * $payment->tax) / 100 : 0;
                                        $totalAmount = $payment->price + $taxAmount;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $payment->invoice_number ?? '—' }}</td>
                                        <td>{{ trim(($payment->customer->first_name ?? '') . ' ' . ($payment->customer->last_name ?? '')) ?: '—' }}</td>
                                        <td>{{ $payment->user->name ?? '—' }}</td>
                                        <td>{{ $payment->brand->name ?? '—' }}</td>
                                        <td>{{ $payment->gateway->name ?? '—' }}</td>
                                        <td>{{ number_format($totalAmount, 2) }}</td>
                                        <td>{{ strtoupper($payment->currency ?? '') }}</td>
                                        <td>
                                            <span class="badge {{ $payment->status === 'unpaid' ? 'bg-danger' : 'bg-success' }}">{{ $payment->status }}</span>
                                        </td>
                                        <td>{{ $payment->updated_at?->format('d M Y, h:i A') }}</td>
                                        <td>
                                            @if (!empty($payment->invoice_number))
                                                <a href="{{ url('/invoice/' . $payment->invoice_number) }}"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="Open invoice">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16" aria-hidden="true">
                                                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                                                        <path
                                                            d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1" />
                                                    </svg>
                                                    <span class="sr-only">Invoice</span>
                                                </a>
                                            @else
                                                —
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
