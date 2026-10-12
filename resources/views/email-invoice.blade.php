<!DOCTYPE html>
<html class="no-js" lang="en"
    style="line-height: 1.5em;-webkit-text-size-adjust: 100%;color: #777777;font-family: &quot;Inter&quot;, sans-serif;font-size: 14px;font-weight: 400;overflow-x: hidden;background-color: #f5f7ff;">
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

<body
    style="margin: 0;color: #777777;font-family: &quot;Inter&quot;, sans-serif;font-size: 14px;font-weight: 400;line-height: 1.5em;overflow-x: hidden;background-color: #f5f7ff;">
    @php
        $taxAmount = ($payment->price * $payment->tax) / 100;
        $totalAmount = $payment->price + $taxAmount;
    @endphp
    <input type="hidden" value="{{ $payment->invoice_number }}" id="invoiceNumber"
        style="font-family: inherit;font-size: 100%;line-height: 1.15;margin: 0;overflow: visible;">
    <div class="cs-container"
        style="margin-top: 0;line-height: 1.5em;max-width: 880px;padding: 30px 15px;margin-left: auto;margin-right: auto;z-index: 10;">
        <div class="cs-invoice cs-style1"
            style="margin-top: 0;line-height: 1.5em;background: #fff;border-radius: 10px;padding: 50px;">
            <div class="cs-invoice_in" id="download_section" style="margin-top: 0;line-height: 1.5em;">
                <div class="cs-invoice_head cs-type1 cs-mb25"
                    style="margin-top: 0;line-height: 1.5em;margin-bottom: 25px;display: flex;justify-content: space-between;align-items: flex-end;padding-bottom: 25px;border-bottom: 1px solid #eaeaea;">
                    @php
                        $inv_status = strtolower($payment->status) === 'paid' ? 'paid' : 'unpaid';
                    @endphp
                    <div class="cs-invoice_left" style="margin-top: 0;line-height: 1.5em;max-width: 55%;">
                        <p class="cs-invoice_number cs-primary_color cs-mb5 cs-f16"
                            style="margin-top: 0;line-height: 1.5em;margin-bottom: 5px;font-size: 16px;color: #111111;">
                            <b class="cs-primary_color" style="font-weight: bold;color: #111111;">Invoice
                                No:</b> {{ $payment->invoice_number }}
                        </p>
                        <p class="cs-invoice_date cs-primary_color cs-m0"
                            style="margin-top: 0;line-height: 1.5em;margin-bottom: 15px;color: #111111;margin: 0px !important;">
                            <b class="cs-primary_color" style="font-weight: bold;color: #111111;">Date:
                            </b>{{ $payment->created_at->format('d-m-y') }}
                        </p>
                        <p class="cs-invoice_date cs-primary_color cs-m0 ]"
                            style="margin-top: 0;line-height: 1.5em;margin-bottom: 15px;color: #111111;margin: 0px !important;">
                            <b class="cs-primary_color" style="font-weight: bold;color: #111111;">Status:
                            </b><span class="{{ $inv_status == 'paid' ? 'badge-paid' : 'badge-unpaid' }}">
                                {{ $payment->status }}</span>
                        </p>
                    </div>
                    <div class="cs-invoice_right cs-text_right"
                        style="margin-top: 0;line-height: 1.5em;text-align: right;">
                        @if (!empty($payment->brand->logo_path))
                            <div class="cs-logo cs-mb5" style="margin-top: 0;line-height: 1.5em;margin-bottom: 5px;">
                                <img src="{{ asset('storage/' . $payment->brand->logo_path) }}" alt="Logo"
                                    style="border-style: none;border: 0;max-width: 50%;height: auto;vertical-align: middle;">
                            </div>
                        @endif

                    </div>
                </div>
                <div class="cs-invoice_head cs-mb10"
                    style="margin-top: 0;line-height: 1.5em;margin-bottom: 10px;display: flex;justify-content: space-between;">
                    <div class="cs-invoice_left" style="margin-top: 0;line-height: 1.5em;max-width: 55%;">
                        <b class="cs-primary_color" style="font-weight: bold;color: #111111;">Invoice To:</b>
                            <p>Name: {{ $payment->customer->first_name ?? 'N/A' }}
                                {{ $payment->customer->last_name ?? '' }}<br>
                                Email: {{ $payment->customer->email ?? 'N/A' }}<br>
                                Phone Number: {{ $payment->customer->phone_number ?? 'N/A' }}<br>
                            </p>
                    </div>
                    <div class="cs-invoice_right cs-text_right"
                        style="margin-top: 0;line-height: 1.5em;text-align: right;">
                        <b class="cs-primary_color" style="font-weight: bold;color: #111111;">Pay To:</b>
                        <p style="margin-top: 0;line-height: 1.5em;margin-bottom: 15px;">
                            {{ $payment->brand->name }} <br>
                        </p>
                    </div>
                </div>
                <div class="cs-table cs-style1" style="margin-top: 0;line-height: 1.5em;">
                    <div class="cs-round_border"
                        style="margin-top: 0;line-height: 1.5em;border: 1px solid #eaeaea;overflow: hidden;border-radius: 6px;">
                        <div class="cs-table_responsive" style="margin-top: 0;line-height: 1.5em;overflow-x: auto;">
                            <table style="width: 100%;caption-side: bottom;border-collapse: collapse;min-width: 600px;">
                                <thead>
                                    <tr>
                                        <th class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg"
                                            style="text-align: left;padding: 10px 15px;line-height: 1.55em;font-weight: 600;width: 25%;color: #111111;background: #f6f6f6;">
                                            Item</th>
                                        <th class="cs-width_4 cs-semi_bold cs-primary_color cs-focus_bg"
                                            style="text-align: left;padding: 10px 15px;line-height: 1.55em;font-weight: 600;width: 33.33333333%;color: #111111;background: #f6f6f6;">
                                            Description
                                        </th>
                                        <th class="cs-width_2 cs-semi_bold cs-primary_color cs-focus_bg"
                                            style="text-align: left;padding: 10px 15px;line-height: 1.55em;font-weight: 600;width: 16.66666667%;color: #111111;background: #f6f6f6;">
                                            Qty</th>
                                        <th class="cs-width_1 cs-semi_bold cs-primary_color cs-focus_bg"
                                            style="text-align: left;padding: 10px 15px;line-height: 1.55em;font-weight: 600;width: 8%;color: #111111;background: #f6f6f6;">
                                            Price</th>
                                        <th class="cs-width_2 cs-semi_bold cs-primary_color cs-focus_bg cs-text_right"
                                            style="text-align: right;padding: 10px 15px;line-height: 1.55em;font-weight: 600;width: 16.66666667%;color: #111111;background: #f6f6f6;">
                                            Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="cs-width_3"
                                            style="border-top: 1px solid #eaeaea;padding: 10px 15px;line-height: 1.55em;width: 25%;">
                                            {{ $payment->package_name }}</td>
                                        <td class="cs-width_4"
                                            style="border-top: 1px solid #eaeaea;padding: 10px 15px;line-height: 1.55em;width: 33.33333333%;">
                                            {{ $payment->description }}</td>
                                        <td class="cs-width_2"
                                            style="border-top: 1px solid #eaeaea;padding: 10px 15px;line-height: 1.55em;width: 16.66666667%;">
                                            1</td>
                                        <td class="cs-width_1"
                                            style="border-top: 1px solid #eaeaea;padding: 10px 15px;line-height: 1.55em;width: 8%;">
                                            {{ $payment->currency == 'usd' ? '$' : '' }}
                                            {{ $payment->currency == 'gbp' ? '£' : '' }}
                                            {{ $payment->price }}
                                        </td>
                                        <td class="cs-width_2 cs-text_right"
                                            style="border-top: 1px solid #eaeaea;padding: 10px 15px;line-height: 1.55em;width: 16.66666667%;text-align: right;">
                                            {{ $payment->currency == 'usd' ? '$' : '' }}
                                            {{ $payment->currency == 'gbp' ? '£' : '' }}
                                            {{ $payment->price }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="cs-invoice_footer cs-border_top"
                            style="margin-top: 0;line-height: 1.5em;border-top: 1px solid #eaeaea;display: flex;">
                            <div class="cs-left_footer cs-mobile_hide"
                                style="margin-top: 0;line-height: 1.5em;width: 55%;padding: 10px 15px;">
                                <p class="cs-mb0" style="margin-top: 0;line-height: 1.5em;margin-bottom: 0px;"><b
                                        class="cs-primary_color" style="font-weight: bold;color: #111111;">Additional
                                        Information:</b></p>
                                <p class="cs-m0"
                                    style="margin-top: 0;line-height: 1.5em;margin-bottom: 15px;margin: 0px !important;">
                                    At check in you may need to present the credit <br>card used for
                                    payment of this ticket.</p>
                            </div>
                            <div class="cs-right_footer" style="margin-top: 0;line-height: 1.5em;width: 46%;">
                                <table
                                    style="width: 100%;caption-side: bottom;border-collapse: collapse;margin-top: -1px;">
                                    <tbody>
                                        <tr class="cs-border_left" style="border-left: 1px solid #eaeaea;">
                                            <td class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg"
                                                style="border-top: 1px solid #eaeaea;padding: 10px 15px;line-height: 1.55em;font-weight: 600;width: 25%;color: #111111;background: #f6f6f6;">
                                                Subtotal
                                            </td>
                                            <td class="cs-width_3 cs-semi_bold cs-focus_bg cs-primary_color cs-text_right"
                                                style="border-top: 1px solid #eaeaea;padding: 10px 15px;line-height: 1.55em;font-weight: 600;width: 25%;color: #111111;background: #f6f6f6;text-align: right;">
                                                {{ $payment->currency == 'usd' ? '$' : '' }}
                                                {{ $payment->currency == 'gbp' ? '£' : '' }}
                                                {{ $payment->price }}</td>
                                        </tr>
                                        <tr class="cs-border_left" style="border-left: 1px solid #eaeaea;">
                                            <td class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg"
                                                style="border-top: 1px solid #eaeaea;padding: 10px 15px;line-height: 1.55em;font-weight: 600;width: 25%;color: #111111;background: #f6f6f6;">
                                                Tax</td>
                                            <td class="cs-width_3 cs-semi_bold cs-focus_bg cs-primary_color cs-text_right"
                                                style="border-top: 1px solid #eaeaea;padding: 10px 15px;line-height: 1.55em;font-weight: 600;width: 25%;color: #111111;background: #f6f6f6;text-align: right;">
                                                {{ $payment->tax }}%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="cs-invoice_footer" style="margin-top: 0;line-height: 1.5em;display: flex;">
                        <div class="cs-left_footer cs-mobile_hide"
                            style="margin-top: 0;line-height: 1.5em;width: 55%;padding: 10px 15px;"></div>
                        <div class="cs-right_footer" style="margin-top: 0;line-height: 1.5em;width: 46%;">
                            <table
                                style="width: 100%;caption-side: bottom;border-collapse: collapse;margin-top: -1px;">
                                <tbody>
                                    <tr class="cs-border_none" style="border: none;">
                                        <td class="cs-width_3 cs-border_top_0 cs-bold cs-f16 cs-primary_color"
                                            style="border-top: 0;padding: 10px 15px;line-height: 1.55em;font-size: 16px;font-weight: 700;width: 25%;color: #111111;">
                                            Total
                                            Amount</td>
                                        <td class="cs-width_3 cs-border_top_0 cs-bold cs-f16 cs-primary_color cs-text_right"
                                            style="border-top: 0;padding: 10px 15px;line-height: 1.55em;font-size: 16px;font-weight: 700;width: 25%;color: #111111;text-align: right;">
                                            {{ $payment->currency == 'usd' ? '$' : '' }}
                                            {{ $payment->currency == 'gbp' ? '£' : '' }}
                                            {{ $totalAmount }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="cs-note"
                    style="margin-top: 40px;line-height: 1.5em;display: flex;align-items: flex-start;">
                    <div class="cs-note_left"
                        style="margin-top: 6px;line-height: 1.5em;margin-right: 10px;margin-left: -5px;display: flex;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewbox="0 0 512 512"
                            style="width: 32px;">
                            <path
                                d="M416 221.25V416a48 48 0 01-48 48H144a48 48 0 01-48-48V96a48 48 0 0148-48h98.75a32 32 0 0122.62 9.37l141.26 141.26a32 32 0 019.37 22.62z"
                                fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32">
                            </path>
                            <path d="M256 56v120a32 32 0 0032 32h120M176 288h160M176 368h160" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="32"></path>
                        </svg>
                    </div>
                    <div class="cs-note_right" style="margin-top: 0;line-height: 1.5em;">
                        <p class="cs-mb0" style="margin-top: 0;line-height: 1.5em;margin-bottom: 0px;"><b
                                class="cs-primary_color cs-bold" style="font-weight: 700;color: #111111;">Note:</b>
                        </p>
                        <p class="cs-m0"
                            style="margin-top: 0;line-height: 1.5em;margin-bottom: 15px;margin: 0px !important;">If you
                            have any questions or concerns related to this invoice, please do not
                            hesitate to contact us at our customer service.</p>
                    </div>
                </div><!-- .cs-note -->
            </div>
        </div>
        @if ($inv_status == 'unpaid')
            <div>
                <a href="{{ url('/proceed/' . $payment->invoice_number) }}" class="custom-button"
                    style="width: 100%;display: inline-block;background-color: #333;color: white;text-decoration: none;padding: 10px 20px;margin-top: 10px;border-radius: 8px;font-size: 16px;font-weight: bold;text-align: center;transition: background-color 0.3s, transform 0.2s;">Proceed</a>
            </div>
        @endif
    </div>
</body>

</html>
