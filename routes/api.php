<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Authorize.Net webhooks: POST JSON with X-ANET-Signature (HMAC-SHA512).
// Full URL: {APP_URL}/api/payment/authorize/webhook
Route::post('payment/authorize/webhook', [PaymentController::class, 'authorize_webhook'])
    ->name('authorize.webhook');
