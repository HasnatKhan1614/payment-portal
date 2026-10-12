<?php

return [
    'login_id' => env('AUTHORIZE_LOGIN_ID'),
    'transaction_key' => env('AUTHORIZE_TRANSACTION_KEY'),
    // sandbox | production
    'mode' => env('AUTHORIZE_MODE', env('APP_ENV') === 'production' ? 'production' : 'sandbox'),
];

