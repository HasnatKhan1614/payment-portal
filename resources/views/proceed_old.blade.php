
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>PAY PORTAL</title>
    <link rel="icon" type="image/x-icon" href="{{env('ASSET_URL')}}/assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="{{env('ASSET_URL')}}/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{env('ASSET_URL')}}/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{env('ASSET_URL')}}/assets/css/pages/privacy/privacy.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
    
</head>
<body>
    

    {{-- <div id="headerWrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-12 text-center mb-5">
                    <a href="index.html" class="navbar-brand-privacy">
                        <img src="assets/img/90x90.jpg" class="img-fluid" alt="logo">
                    </a>
                </div>
                <div class="col-md-12 col-sm-12 col-12 text-center">
                    <h2 class="main-heading">Brand Name</h2>
                </div>
            </div>
        </div>
    </div> --}}

    <div id="privacyWrapper" class="">
        <div class="privacy-container">
            <div class="privacyContent">

                <div class="d-flex justify-content-center privacy-head">
                    <div class="privacyHeader">
                        <h1>Payment Details</h1>
                        {{-- <p>Updated Sep 15, 2019</p> --}}
                    </div>
    
                </div>
                <div class="widget-content">
                    <div class="invoice-box">
                        <div class="inv-detail">                                        
                            <div class="info-detail-1 mb-5" style="display: flex;justify-content: space-between;">
                                <h6>Customer Name</h6>
                                <h6>{{$payment->customer->first_name}} {{$payment->customer->last_name}}</h6>
                            </div>
                            <div class="info-detail-2 mb-5" style="display: flex;justify-content: space-between;">
                                <h6>Customer Email</h6>
                                <h6>{{$payment->customer->email}}</h6>
                            </div>
                            <div class="info-detail-3 info-sub " >
                                <div class="info-detail mb-5" style="display: flex;justify-content: space-between;">
                                    <h6>Invoice</h6>
                                    <h6>{{$payment->invoice_number}}</h6>
                                </div>
                                <div class="info-detail-sub mb-5" style="display: flex;justify-content: space-between;">
                                    <h6>Package Name</h6>
                                    <h6>{{$payment->description}}</h6>
                                </div>
                                <div class="info-detail-sub mb-5" style="display: flex;justify-content: space-between;">
                                    <h6>Subtotal</h6>
                                    <h6>
                                        {{$payment->currency == 'usd' ? '$' : ''}}
                                        {{$payment->currency == 'gbp' ? '£' : ''}}
                                        {{$payment->price}}
                                    </h6>
                                </div>
                                <div class="info-detail-sub mb-5" style="display: flex;justify-content: space-between;">
                                    <h6>Tax</h6>
                                    <h6>
                                        {{$payment->currency == 'usd' ? '$' : ''}}
                                        {{$payment->currency == 'gbp' ? '£' : ''}}
                                        {{$payment->tax}}
                                    </h6>
                                </div>
                                <div class="info-detail-sub mb-5" style="display: flex;justify-content: space-between;">
                                    <h6>Total</h6>
                                    @if(isset($payment->tax) && isset($payment->price))
                                        <h6>
                                            {{$payment->currency == 'usd' ? '$' : ''}}
                                            {{$payment->currency == 'gbp' ? '£' : ''}}
                                            {{ $payment->tax + $payment->price }}
                                        </h6>
                                    @endif
                                </div>
                                <div class="info-detail-sub mb-5" style="display: flex;justify-content: space-between;">
                                    <h6>Remaining</h6>
                                    <h6>
                                        {{$payment->currency == 'usd' ? '$' : ''}}
                                        {{$payment->currency == 'gbp' ? '£' : ''}}
                                        {{ $payment->remaining }}
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <div class="inv-action d-flex justify-content-center">
                            <a href="{{ url('/pay/'.$payment->invoice_number) }}" class="btn btn-dark">Proceed</a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{env('ASSET_URL')}}/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="{{env('ASSET_URL')}}/bootstrap/js/popper.min.js"></script>
    <script src="{{env('ASSET_URL')}}/bootstrap/js/bootstrap.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <script>
        // Scroll To Top
        $(document).on('click', '.arrow', function(event) {
          event.preventDefault();
          var body = $("html, body");
          body.stop().animate({scrollTop:0}, 500, 'swing');
        });
    </script>

</body>
</html>