<?php
require_once('../autoload.php');
spl_autoload_register('BootpayAutoload');

use Bootpay\Rest\BootpayApi;

$bootpay = BootpayApi::setConfig(
    '59bfc738e13f337dbd6ca48a',
    'pDc0NwlkEX3aSaHTp/PPL/i8vn5E/CqRChgyEp/gHD0=',
    'development'
);

$response = $bootpay->requestAccessToken();

if ($response->status === 200) {
    $result = $bootpay->requestPayment([
        'methods' => ['card', 'phone'],
        'order_id' => time(),
        'price' => 1000,
        'name' => '테스트 부트페이 상품',
        # 결제 정보를 리턴받은 URL
        'return_url' => 'https://dev-api.bootpay.co.kr/callback',
        'extra' => [
            'expire' => 30
        ]
    ]);
    var_dump($result);
}