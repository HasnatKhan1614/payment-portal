<!DOCTYPE html>
<html>

<head>
    <title>Invoice From {{ $payment->brand->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <title>General Invoice</title>
    <link rel="stylesheet" href="{{ env('ASSET_URL') }}/invoice/assets/css/style.css">
    <style>
        .badge-unpaid {
            background-color: red;
            color: white;
            padding: 4px 8px;
            text-align: center;
            border-radius: 5px;
        }

        .badge-paid {
            background-color: #8dbf42 !important;
            color: white;
            padding: 4px 8px;
            text-align: center;
            border-radius: 5px;
        }
    </style>

    <style>
        .badge-unpaid {
            background-color: red;
            color: white;
            padding: 4px 8px;
            text-align: center;
            border-radius: 5px;
        }

        .badge-paid {
            background-color: #8dbf42 !important;
            color: white;
            padding: 4px 8px;
            text-align: center;
            border-radius: 5px;
        }

        .custom-button {
            width: 100%;
            display: inline-block;
            background-color: #333;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin-top: 10px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s, transform 0.2s;
        }

        .custom-button:hover {
            background-color: #555;
            transform: translateY(-2px);
        }

        .custom-button:active {
            background-color: #222;
            transform: translateY(0);
        }
    </style>


</head>

<body>
    @php
        $taxAmount = ($payment->price * $payment->tax) / 100;
        $totalAmount = $payment->price + $taxAmount;
    @endphp
    <input type="hidden" value="{{ $payment->invoice_number }}" id="invoiceNumber">

    @php
        $showInvoicePrintDownload = strtolower((string) $payment->status) === 'paid';
    @endphp
    @if ($payment->gateway->type == 'paypal' && $payment->status !== 'paid')
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    @include('partials.invoice', ['showPrintDownload' => $showInvoicePrintDownload])
                </div>

                <div class="col-12 col-md-6">

                    <div class="cs-container">
                        <div id="paypal-button-container"></div>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                        <script src="https://www.paypal.com/sdk/js?client-id={{ $payment->gateway->key1 }}&currency={{ strtoupper($payment->currency) }}&components=buttons,funding-eligibility,googlepay&enable-funding=venmo,paylater"></script>
                        <script>
                            var appUrl = "{{ env('APP_URL') }}";
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            paypal.Buttons({
                                createOrder: function(data, actions) {
                                    return actions.order.create({
                                        purchase_units: [{
                                            amount: {
                                                value: {{ $totalAmount }} // Replace with the actual amount
                                            }
                                        }],
                                        application_context: {
                                            shipping_preference: 'NO_SHIPPING',
                                            billing_preference: "NO_BILLING"
                                        },
                                        payer: {
                                            name: {
                                                given_name: "{{ $payment->customer->name }}",
                                                surname: "{{ $payment->customer->name }}"
                                            },
                                            email_address: "{{ $payment->customer->email }}",
                                            address: {
                                                address_line_1: '1234 Main Street',
                                                admin_area_2: 'Anytown',
                                                admin_area_1: 'CA',
                                                postal_code: '98765',
                                                country_code: 'US'
                                            }
                                        }
                                    });
                                },
                                onApprove: function(data, actions) {

                                    return actions.order.capture().then(function(details) {


                                        var invoice_number = "{{ $payment->invoice_number }}";




                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        $.ajax({
                                            url: "{{ route('paypal.success') }}", // Replace with your server URL
                                            method: 'POST',
                                            data: {
                                                invoice_number: invoice_number,
                                                status: 'COMPLETED',
                                            },
                                            success: function(response) {
                                                if (response.status === 'ok') {
                                                    window.location.href = appUrl + '/invoice/' +
                                                        invoice_number;

                                                }
                                            },

                                            error: function(xhr, status, error) {
                                                console.error(
                                                    'Error sending transaction details to the server: ' +
                                                    error);
                                            }
                                        });



                                    });
                                },
                                /*application_context: {
                                    shipping_preference: "NO_SHIPPING",
                                    billing_preference: "NO_BILLING"
                                }*/
                            }).render('#paypal-button-container');
                        </script>
                    </div>


                </div>
            </div>
        </div>
    @elseif ($payment->gateway->type == 'authorize' && $payment->status !== 'paid')
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    @include('partials.invoice', ['showPrintDownload' => $showInvoicePrintDownload])
                </div>
                <div class="col-12 col-md-6">
                    <div class="cs-container">
                        <div class="cs-note">
                            <div class="cs-note_right">
                                <p class="cs-mb0"><b class="cs-primary_color cs-bold">Pay with Card</b></p>
                                <p class="cs-m0">You’ll be redirected to a secure Authorize.Net checkout page to complete your payment.</p>
                            </div>
                        </div>
                        <a href="{{ route('authorize.start', ['invoice_number' => $payment->invoice_number]) }}" class="custom-button">
                            Pay Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    @include('partials.invoice', ['showPrintDownload' => $showInvoicePrintDownload])
                </div>
                <div class="col-12 col-md-6">
                    <div class="cs-container">
                        @php
                            $inv_status = strtolower($payment->status) === 'paid' ? 'paid' : 'unpaid';
                        @endphp
                        @if ($inv_status == 'unpaid')
                            <a href="{{ url('/pay/' . $payment->invoice_number) }}" class="custom-button">Proceed</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    <script src="{{ env('ASSET_URL') }}/invoice/assets/js/jquery.min.js"></script>
    <script src="{{ env('ASSET_URL') }}/invoice/assets/js/jspdf.min.js"></script>
    <script src="{{ env('ASSET_URL') }}/invoice/assets/js/html2canvas.min.js"></script>
    <script src="{{ env('ASSET_URL') }}/invoice/assets/js/main.js"></script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/6859f6e18994d9191028302b/1iufmool3';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->


</body>



</html>
