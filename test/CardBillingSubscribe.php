<?php
/*
 * 카드 정기 결제
 */
require_once('../autoload.php');
spl_autoload_register('BootpayAutoload');

use Bootpay\Rest\BootpayApi;

$billingKey = '5b025b33e13f33310ce560fb';

$bootpay = BootpayApi::setConfig(
    '59bfc738e13f337dbd6ca48a',
    'FQj3jOvQYp053nxzWxHSuw+cq3zUlSWZV2ec/8fkiyA='
);

$response = $bootpay->requestAccessToken();

if ($response->status === 200) {
    $result = $bootpay->subscribeCardBilling([
        'billing_key' => $billingKey,
        'item_name' => '정기결제 테스트 아이템',
        'price' => 3000,
        'order_id' => time()
    ]);
    var_dump($result);
}