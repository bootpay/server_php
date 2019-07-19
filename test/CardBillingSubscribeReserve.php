<?php
/*
 * 카드 정기 결제 예약
 */
require_once('../autoload.php');
spl_autoload_register('BootpayAutoload');

use Bootpay\Rest\BootpayApi;

$billingKey = '5b025b33e13f33310ce560fb';

$bootpay = BootpayApi::setConfig(
    '59bfc738e13f337dbd6ca48a',
    'pDc0NwlkEX3aSaHTp/PPL/i8vn5E/CqRChgyEp/gHD0='
);

$response = $bootpay->requestAccessToken();

if ($response->status === 200) {
    $result = $bootpay->subscribeCardBillingReserve([
        'billing_key' => $billingKey,
        'item_name' => '정기결제 테스트 아이템',
        'price' => 3000,
        'order_id' => time(),
        'execute_at' => time() + 10,
        'scheduler_type' => 'oneshot'
    ]);
    var_dump($result);
}