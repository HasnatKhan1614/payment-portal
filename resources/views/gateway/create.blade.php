@extends('layouts.app')

@section('content')
    <div id="content" class="main-content">
        <div class="container">
            <div class="container">
                <!-- resources/views/livewire/gateways-create-or-edit.blade.php -->
                <div class="row">
                    <div id="flFormsGrid" class="col-lg-12 layout-spacing layout-top-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>Create Gateway</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <form id="createGatewayForm">
                                    <div class="form-row mb-4">
                                        <label for="name">Type</label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="stripe">Stripe</option>
                                            <option value="paypal">Paypal</option>
                                            <option value="authorize">Authorize.Net</option>
                                        </select>
                                        <span class="text-danger error-message" id="name_error"></span>
                                    </div>
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-12">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="First Name">
                                            <span class="text-danger error-message" id="name_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-12">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="1" selected>Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            <span class="text-danger error-message" id="status_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-12">
                                            <label for="key1" id="key1_label">KEY 1</label>
                                            <input type="text" class="form-control" id="key1" name="key1"
                                                placeholder="First Name">
                                            <span class="text-danger error-message" id="key1_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-12">
                                            <label for="key2" id="key2_label">KEY 2</label>
                                            <input type="text" class="form-control" id="key2" name="key2"
                                                placeholder="First Name">
                                            <span class="text-danger error-message" id="key2_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-row mb-4" id="gateway_key3_wrap" style="display: none;">
                                        <div class="form-group col-md-12">
                                            <label for="key3" id="key3_label">Signature key (KEY 3, optional)</label>
                                            <input type="text" class="form-control" id="key3" name="key3"
                                                placeholder="Authorize.Net Account → API Credentials &amp; Keys → Signature Key"
                                                autocomplete="off">
                                            <small class="text-muted">Optional; for your records only.</small>
                                            <span class="text-danger error-message" id="key3_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-row mb-4" id="gateway_webhook_wrap" style="display: none;">
                                        <div class="form-group col-md-12">
                                            <label>Authorize.Net Webhook URL (example)</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="authorize_webhook_url" readonly
                                                    value="{{ route('authorize.webhook') }}">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-secondary copy-btn"
                                                        data-copy-target="#authorize_webhook_url">Copy</button>
                                                </div>
                                            </div>
                                            <small class="text-muted">Use this URL in Authorize.Net webhook settings.</small>
                                        </div>
                                    </div>
                                    <button type="button" id="CreateGetwaySubmitBtn" class="btn btn-primary mt-3">Save
                                        Gateway</button>
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
    <script src="{{ env('ASSET_URL') }}/custom/custom.js"></script>
    <script>
        (function() {
            function updateGatewayKeyLabels(type) {
                const key1Label = document.getElementById('key1_label');
                const key2Label = document.getElementById('key2_label');
                const key3Wrap = document.getElementById('gateway_key3_wrap');
                const webhookWrap = document.getElementById('gateway_webhook_wrap');
                if (!key1Label || !key2Label) return;

                if (type === 'stripe') {
                    key1Label.textContent = 'Publishable key (KEY 1)';
                    key2Label.textContent = 'Secret key (KEY 2)';
                } else if (type === 'paypal') {
                    key1Label.textContent = 'Client ID (KEY 1)';
                    key2Label.textContent = 'Client Secret (KEY 2)';
                } else if (type === 'authorize') {
                    key1Label.textContent = 'Login ID (KEY 1)';
                    key2Label.textContent = 'Transaction Key (KEY 2)';
                } else {
                    key1Label.textContent = 'KEY 1';
                    key2Label.textContent = 'KEY 2';
                }
                if (key3Wrap) {
                    key3Wrap.style.display = type === 'authorize' ? '' : 'none';
                }
                if (webhookWrap) {
                    webhookWrap.style.display = type === 'authorize' ? '' : 'none';
                }
            }

            const typeEl = document.getElementById('type');
            if (typeEl) {
                updateGatewayKeyLabels(typeEl.value);
                typeEl.addEventListener('change', function() {
                    updateGatewayKeyLabels(typeEl.value);
                });
            }

            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.copy-btn');
                if (!btn) return;
                const selector = btn.getAttribute('data-copy-target');
                const input = selector ? document.querySelector(selector) : null;
                if (!input) return;
                input.select();
                input.setSelectionRange(0, 99999);
                document.execCommand('copy');
                Snackbar.show({ text: 'Copied!', duration: 2000 });
            });
        })();
    </script>
@endsection
