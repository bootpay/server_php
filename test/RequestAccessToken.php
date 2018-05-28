<?php
spl_autoload_register(function ($class) {
    $base_dir = __DIR__ . "/../";
    $file = $base_dir . str_replace('\\', '/', $class) . ".php";
    if (file_exists($file)) {
        require $file;
    }
});

use Bootpay\Rest\BootpayApi;

$bootpay = BootpayApi::setConfig(
    '59bfc738e13f337dbd6ca48a',
    'FQj3jOvQYp053nxzWxHSuw+cq3zUlSWZV2ec/8fkiyA=',
    'development'
);

$response = $bootpay->requestAccessToken();
if ($response->status === 200) {
    print $response->data->token . "\n";
    print $response->data->server_time . "\n";
    print $response->data->expired_at . "\n";
}