<?php

namespace App\Services;

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use net\authorize\api\constants\ANetEnvironment;

class AuthorizeNetService
{
    public function createHostedPaymentPageToken(array $payload): array
    {
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($payload['login_id']);
        $merchantAuthentication->setTransactionKey($payload['transaction_key']);

        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($payload['amount']);

        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($payload['invoice_number']);
        $order->setDescription($payload['description'] ?? $payload['invoice_number']);
        $transactionRequestType->setOrder($order);

        $customer = new AnetAPI\CustomerDataType();
        $customer->setEmail($payload['customer_email']);
        $transactionRequestType->setCustomer($customer);

        $request = new AnetAPI\GetHostedPaymentPageRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setTransactionRequest($transactionRequestType);
        // Used by webhooks as `merchantReferenceId` so we can map the event to our invoice.
        $request->setRefId($payload['merchant_reference_id'] ?? $payload['invoice_number']);

        $settings = [];

        // Return URL after payment. Authorize.Net posts/redirects back to this URL.
        $returnOptions = new AnetAPI\SettingType();
        $returnOptions->setSettingName("hostedPaymentReturnOptions");
        $returnOptions->setSettingValue(json_encode([
            // Note: in full-page redirect mode, Authorize.Net may still show the receipt page.
            // We still provide the return URL so the "Continue" button returns to our site.
            'showReceipt' => false,
            'url' => $payload['return_url'],
            'urlText' => 'Get Invoice',
            'cancelUrl' => $payload['cancel_url'],
            'cancelUrlText' => 'Cancel',
        ]));
        $settings[] = $returnOptions;

        // Basic UX defaults
        $billingOptions = new AnetAPI\SettingType();
        $billingOptions->setSettingName("hostedPaymentBillingAddressOptions");
        // Hide billing address collection on the hosted form (wallets/banks will provide what they can).
        $billingOptions->setSettingValue(json_encode(['show' => true, 'required' => false]));
        $settings[] = $billingOptions;

        $shippingOptions = new AnetAPI\SettingType();
        $shippingOptions->setSettingName("hostedPaymentShippingAddressOptions");
        $shippingOptions->setSettingValue(json_encode(['show' => false, 'required' => false]));
        $settings[] = $shippingOptions;

        // Show any additional methods enabled on the merchant account (e.g., eCheck/Bank Account).
        // Actual availability depends on the Authorize.Net account configuration and buyer eligibility.
        $paymentOptions = new AnetAPI\SettingType();
        $paymentOptions->setSettingName("hostedPaymentPaymentOptions");
        $paymentOptions->setSettingValue(json_encode([
            'showCreditCard' => true,
            'showBankAccount' => true,
        ]));
        $settings[] = $paymentOptions;

        $securityOptions = new AnetAPI\SettingType();
        $securityOptions->setSettingName("hostedPaymentSecurityOptions");
        $securityOptions->setSettingValue(json_encode(['captcha' => false]));
        $settings[] = $securityOptions;

        $request->setHostedPaymentSettings($settings);

        $controller = new AnetController\GetHostedPaymentPageController($request);
        $response = $controller->executeWithApiResponse($this->environment($payload['mode'] ?? null));

        if (!$response) {
            return ['ok' => false, 'error' => 'No response from Authorize.Net'];
        }

        $messages = $response->getMessages();
        if (!$messages || $messages->getResultCode() !== "Ok") {
            $first = $messages?->getMessage()[0] ?? null;
            return [
                'ok' => false,
                'error' => $first ? ($first->getCode() . ': ' . $first->getText()) : 'Authorize.Net error',
            ];
        }

        return ['ok' => true, 'token' => $response->getToken()];
    }

    public function hostedPaymentUrl(?string $mode = null): string
    {
        $mode = $mode ?: config('authorizenet.mode');

        return $mode === 'production'
            ? 'https://accept.authorize.net/payment/payment'
            : 'https://test.authorize.net/payment/payment';
    }

    private function environment(?string $mode = null): string
    {
        $mode = $mode ?: config('authorizenet.mode');

        return $mode === 'production'
            ? ANetEnvironment::PRODUCTION
            : ANetEnvironment::SANDBOX;
    }
}

